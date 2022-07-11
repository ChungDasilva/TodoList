<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>HTML5/JavaScript Calendar with Day/Week/Month Views (PHP, MySQL)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="/public/css/calendar.css">

  <!-- DayPilot library -->
  <script src="/public/js/daypilot/daypilot-all.min.js"></script>

</head>
<body>
<div class="header">
</div>

<div class="main">
  <div style="display:flex">
    <div style="">
      <div id="nav"></div>
    </div>
    <div style="flex-grow: 1; margin-left: 10px;">
      <div class="toolbar buttons">
        <span class="toolbar-item"><a id="buttonDay" href="#">Day</a></span>
        <span class="toolbar-item"><a id="buttonWeek" href="#">Week</a></span>
        <span class="toolbar-item"><a id="buttonMonth" href="#">Month</a></span>
      </div>
      <div id="dpDay"></div>
      <div id="dpWeek"></div>
      <div id="dpMonth"></div>
    </div>
  </div>
</div>

<script type="text/javascript">


  var nav = new DayPilot.Navigator("nav");
  nav.showMonths = 3;
  nav.skipMonths = 3;
  nav.init();

  var day = new DayPilot.Calendar("dpDay");
  day.viewType = "Day";
  configureCalendar(day);
  day.init();

  var week = new DayPilot.Calendar("dpWeek");
  week.viewType = "Week";
  configureCalendar(week);
  week.init();

  var month = new DayPilot.Month("dpMonth");
  configureCalendar(month);
  month.init();

  function configureCalendar(dp) {
    dp.contextMenu = new DayPilot.Menu({
      items: [
        {
          text: "Delete",
          onClick: function(args) {
            var params = {
              id: args.source.id(),
            };
            DayPilot.Http.ajax({
              url: "/api/v1/tasks/" + params.id + "/delete",
              data: params,
              success: function(ajax) {
                dp.events.remove(params.id);
                dp.message("Deleted");
              }
            });
          }
        },
        {
          text: "-"
        },
        {
          text: "Planning",
          icon: "icon icon-orange",
          status: "Planning",
          onClick: function(args) { updateStatus(args.source, args.item.status); }
        },
        {
          text: "Doing",
          icon: "icon icon-blue",
          status: "Doing",
          onClick: function(args) { updateStatus(args.source, args.item.status); }
        },
        {
          text: "Complete",
          icon: "icon icon-green",
          status: "Complete",
          onClick: function(args) { updateStatus(args.source, args.item.status); }
        }
      ]
    });


    dp.onBeforeEventRender = function(args) {
      if (!args.data.backColor) {
        args.data.backColor = "#e69138";
      }
      args.data.borderColor = "darker";
      args.data.fontColor = "#fff";
      args.data.barHidden = true;

      args.data.areas = [
        {
          right: 2,
          top: 2,
          width: 20,
          height: 20,
          html: "&equiv;",
          action: "ContextMenu",
          cssClass: "area-menu-icon",
          visibility: "Hover"
        }
      ];
    };

    dp.onEventMoved = function (args) {
      DayPilot.Http.ajax({
        url: "/api/v1/tasks/" + args.e.id() + "/move",
        data: {
          id: args.e.id(),
          newStart: args.newStart,
          newEnd: args.newEnd
        },
        success: function() {
          console.log("Moved.");
        }
      });
    };

    dp.onEventResized = function (args) {
      DayPilot.Http.ajax({
        url: "/api/v1/tasks/" + args.e.id() + "/move",
        data: {
          id: args.e.id(),
          newStart: args.newStart,
          newEnd: args.newEnd
        },
        success: function() {
          console.log("Resized.");
        }
      });

    };

    // event creating
    dp.onTimeRangeSelected = function (args) {

      var form = [
        {name: "Name", id: "text"},
        {name: "Start", id: "start", dateFormat: "MMMM d, yyyy h:mm tt", disabled: false},
        {name: "End", id: "end", dateFormat: "MMMM d, yyyy h:mm tt", disabled: false},
      ];

      var data = {
        start: args.start,
        end: args.end,
        text: "Event"
      };

      DayPilot.Modal.form(form, data).then(function(modal) {
        dp.clearSelection();

        if (modal.canceled) {
          return;
        }

        DayPilot.Http.ajax({
          url: "/api/v1/tasks/create",
          data: modal.result,
          success: function(ajax) {
            var dp = switcher.active.control;
            dp.events.add({
              start: data.start,
              end: data.end,
              id: ajax.data.id,
              text: data.text
            });
          }
        });

      });
    };

    dp.onEventClick = function(args) {
      DayPilot.Modal.alert(args.e.data.text);
    };
  }

  var switcher = new DayPilot.Switcher({
    triggers: [
      {id: "buttonDay", view: day },
      {id: "buttonWeek", view: week},
      {id: "buttonMonth", view: month}
    ],
    navigator: nav,
    selectedClass: "selected-button",
    onChanged: function(args) {
      console.log("onChanged fired", args);
      switcher.events.load("/api/v1/tasks");
    }
  });

  switcher.select("buttonWeek");

  function updateStatus(e, status) {
    var params = {
      id: e.data.id,
      status: status
    };
    DayPilot.Http.ajax({
      url: "/api/v1/tasks/"+ e.data.id +"/change-status",
      data: params,
      success: function(ajax) {
        var dp = switcher.active.control;
        if (status == 'Planning') {
          e.data.backColor = '#e69138';
        } else if (status == 'Doing') {
          e.data.backColor = '#3d85c6';
        } else {
          e.data.backColor = '#6aa84f';
        }
        dp.events.update(e);
        dp.message("Status updated");
      }
    });
  }

</script>

</body>
</html>






