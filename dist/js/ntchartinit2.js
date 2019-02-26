
Chart.defaults.global.tooltips.enabled = false;
Chart.defaults.global.tooltips.mode = 'index';
Chart.defaults.global.tooltips.position = 'nearest';
Chart.defaults.global.tooltips.custom = CustomTooltips;

$.ajax({
    url: 'api?completedLine=1',
    success: function (data) {

      // Labels + Dates
      var DateTime = luxon.DateTime;
      var topDay = (data[0]['day']);
      var topDay = DateTime.fromISO(topDay);
      var topDayStr = topDay.toFormat('LLL dd');
      var comp_today = DateTime.local();
      var comp_todayStr = DateTime.local().toFormat('ccc LLL dd');
      var comp_m1 = comp_today.minus({days: 1}).toFormat('ccc LLL dd');
      var comp_m2 = comp_today.minus({days: 2}).toFormat('ccc LLL dd');
      var comp_m3 = comp_today.minus({days: 3}).toFormat('ccc LLL dd');
      var comp_m4 = comp_today.minus({days: 4}).toFormat('ccc LLL dd');
      var comp_m5 = comp_today.minus({days: 5}).toFormat('ccc LLL dd');
      var comp_m6 = comp_today.minus({days: 6}).toFormat('ccc LLL dd');
      var comp_m7 = comp_today.minus({days: 7}).toFormat('ccc LLL dd');
      var comp_m8 = comp_today.minus({days: 8}).toFormat('ccc LLL dd');
      var comp_m9 = comp_today.minus({days: 9}).toFormat('ccc LLL dd');
      var comp_m10 = comp_today.minus({days: 10}).toFormat('ccc LLL dd');
      var comp_m11 = comp_today.minus({days: 11}).toFormat('ccc LLL dd');
      var comp_m12 = comp_today.minus({days: 12}).toFormat('ccc LLL dd');
      var comp_m13 = comp_today.minus({days: 13}).toFormat('ccc LLL dd');

      // date formats for comparing in array
      var func_m0 = DateTime.local().toISODate();
      var func_m1 = comp_today.minus({days: 1}).toISODate();
      var func_m2 = comp_today.minus({days: 2}).toISODate();
      var func_m3 = comp_today.minus({days: 3}).toISODate();
      var func_m4 = comp_today.minus({days: 4}).toISODate();
      var func_m5 = comp_today.minus({days: 5}).toISODate();
      var func_m6 = comp_today.minus({days: 6}).toISODate();
      var func_m7 = comp_today.minus({days: 7}).toISODate();
      var func_m8 = comp_today.minus({days: 8}).toISODate();
      var func_m9 = comp_today.minus({days: 9}).toISODate();
      var func_m10 = comp_today.minus({days: 10}).toISODate();
      var func_m11 = comp_today.minus({days: 11}).toISODate();
      var func_m12 = comp_today.minus({days: 12}).toISODate();
      var func_m13 = comp_today.minus({days: 13}).toISODate();

      // People Counts
      var sst = [];
      var ali = [];
      var fwa = [];

      for ( var i = 0; i < data.length; i++ ) {
        if (data[i]['bearbeitetvon'] == 'fwaleska') {
          fwa.push(data[i]['day']);
        } else if (data[i]['bearbeitetvon'] == 'alissitsin') {
          ali.push(data[i]['day']);
        } else if (data[i]['bearbeitetvon'] == 'sstergiou') {
          sst.push(data[i]['day']);
        }
      }

      function countDays(arr,day) {
        var occurences = arr.filter(function(val) {
          return val === day;
        }).length;
        return occurences;
      }

      var ctx = document.getElementById('completedChart').getContext('2d');
      var chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [comp_m13, comp_m12, comp_m11, comp_m10, comp_m9, comp_m8, comp_m7, comp_m6, comp_m5, comp_m4, comp_m3, comp_m2, comp_m1, comp_todayStr],
          datasets: [{
              // FWALESKA
              label: 'fwaleska',
              backgroundColor: 'rgba(103,178,70,0.1)',
              borderColor: 'rgba(103,178,70,0.8)',
              fill: true,
              data: [countDays(fwa,func_m13), countDays(fwa,func_m12), countDays(fwa,func_m11), countDays(fwa,func_m10), countDays(fwa,func_m9), countDays(fwa,func_m8), countDays(fwa,func_m7), countDays(fwa,func_m6), countDays(fwa,func_m5), countDays(fwa,func_m4), countDays(fwa,func_m3), countDays(fwa,func_m2), countDays(fwa,func_m1), countDays(fwa,func_m0)]
          },{
              // ALISSITSIN
              label: 'alissitsin',
              backgroundColor: 'rgba(249,103,103,0.1)',
              borderColor: 'rgba(249,103,103,0.8)',
              fill: true,
              data: [countDays(ali,func_m13), countDays(ali,func_m12), countDays(ali,func_m11), countDays(ali,func_m10), countDays(ali,func_m9), countDays(ali,func_m8), countDays(ali,func_m7), countDays(ali,func_m6), countDays(ali,func_m5), countDays(ali,func_m4), countDays(ali,func_m3), countDays(ali,func_m2), countDays(ali,func_m1), countDays(ali,func_m0)]
          },{
              // SSTERGIOU
              label: 'sstergiou',
              backgroundColor: 'rgba(36,122,219,0.1)',
              borderColor: 'rgba(36,122,219,0.8)',
              fill: true,
              data: [countDays(sst,func_m13), countDays(sst,func_m12), countDays(sst,func_m11), countDays(sst,func_m10), countDays(sst,func_m9), countDays(sst,func_m8), countDays(sst,func_m7), countDays(sst,func_m6), countDays(sst,func_m5), countDays(sst,func_m4), countDays(sst,func_m3), countDays(sst,func_m2), countDays(sst,func_m1), countDays(sst,func_m0)]
          }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              gridLines: {
                color: 'transparent',
                zeroLineColor: 'transparent'
              },
              ticks: {
                fontSize: 12,
                fontColor: 'rgba(0,0,0,0.6)'
              }
            }],
            yAxes: [{
              // stacked: true,
              display: false,
              ticks: {
                display: false
              }
            }]
          },
          elements: {
            line: {
              tension: 0.3,
              borderWidth: 3
            },
            point: {
              radius: 0,
              hitRadius: 10,
              hoverRadius: 4
            }
          },
          tooltips: {
              mode: 'index'
          },
          layout: {
            padding: {
              top: 10
            }
          }
        }
      });

      var maxY = Math.max(countDays(ali,func_m6), countDays(ali,func_m5), countDays(ali,func_m4), countDays(ali,func_m3), countDays(ali,func_m2), countDays(ali,func_m1), countDays(ali,func_m0),countDays(fwa,func_m6), countDays(fwa,func_m5), countDays(fwa,func_m4), countDays(fwa,func_m3), countDays(fwa,func_m2), countDays(fwa,func_m1), countDays(fwa,func_m0),countDays(sst,func_m6), countDays(sst,func_m5), countDays(sst,func_m4), countDays(sst,func_m3), countDays(sst,func_m2), countDays(sst,func_m1), countDays(sst,func_m0));

  /*******************************
   * line chart 1 - felix
   *******************************/
  
  var fwaTotal = countDays(fwa,func_m6) + countDays(fwa,func_m5) + countDays(fwa,func_m4) + countDays(fwa,func_m3) + countDays(fwa,func_m2) + countDays(fwa,func_m1) + countDays(fwa,func_m0);

  if (fwaTotal > 0) {
    var ctx2 = document.getElementById('fwaLine').getContext('2d');
    var chart = new Chart(ctx2, {
      type: 'line',
      data: {
        labels: [comp_m6, comp_m5, comp_m4, comp_m3, comp_m2, comp_m1, comp_todayStr],
        datasets: [{
            // FWALESKA
            label: 'fwaleska',
            backgroundColor: 'rgba(103,178,70,0.1)',
            borderColor: 'rgba(103,178,70,0.2)',
            fill: true,
            data: [countDays(fwa,func_m6), countDays(fwa,func_m5), countDays(fwa,func_m4), countDays(fwa,func_m3), countDays(fwa,func_m2), countDays(fwa,func_m1), countDays(fwa,func_m0)]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            color: 'transparent',
            zeroLineColor: 'transparent'
          },
          ticks: {
            fontSize: 2,
            fontColor: 'transparent'
          }
        }],
        yAxes: [{
          display: false,
          ticks: {
            display: false,
            suggestedMax: maxY
          }
        }]
      },
      elements: {
        line: {
          tension: 0.4,
          borderWidth: 3
        },
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3
        }
      },
      layout: {
        padding: {
          top: 10
        }
      }

    }
    });
  }

  /*******************************
   * line chart 2 - andreas
   *******************************/
  var aliTotal = countDays(ali,func_m6) + countDays(ali,func_m5) + countDays(ali,func_m4) + countDays(ali,func_m3) + countDays(ali,func_m2) + countDays(ali,func_m1) + countDays(ali,func_m0);

  if (aliTotal > 0) {
    var ctx3 = document.getElementById('aliLine').getContext('2d');
    var chart = new Chart(ctx3, {
      type: 'line',
      data: {
        labels: [comp_m6, comp_m5, comp_m4, comp_m3, comp_m2, comp_m1, comp_todayStr],
        datasets: [{
            // ALISSITSIN
            label: 'alissitsin',
            backgroundColor: 'rgba(249,103,103,0.1)',
            borderColor: 'rgba(249,103,103,0.2)',
            fill: true,
            data: [countDays(ali,func_m6), countDays(ali,func_m5), countDays(ali,func_m4), countDays(ali,func_m3), countDays(ali,func_m2), countDays(ali,func_m1), countDays(ali,func_m0)]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            color: 'transparent',
            zeroLineColor: 'transparent'
          },
          ticks: {
            fontSize: 2,
            fontColor: 'transparent'
          }
        }],
        yAxes: [{
          display: false,
          ticks: {
            display: false,
            suggestedMax: maxY
          }
        }]
      },
      elements: {
        line: {
          tension: 0.4,
          borderWidth: 3
        },
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3
        }
      },
      layout: {
        padding: {
          top: 10
        }
      }

    }
    });
  }

  /*******************************
   * line chart 3 - Stelios
   *******************************/
  var sstTotal = countDays(sst,func_m6) + countDays(sst,func_m5) + countDays(sst,func_m4) + countDays(sst,func_m3) + countDays(sst,func_m2) + countDays(sst,func_m1) + countDays(sst,func_m0);

  if (sstTotal > 0) {
    var ctx4 = document.getElementById('sstLine').getContext('2d');
    var chart = new Chart(ctx4, {
      type: 'line',
      data: {
        labels: [comp_m6, comp_m5, comp_m4, comp_m3, comp_m2, comp_m1, comp_todayStr],
        datasets: [{
            // SSTERGIOU
            label: 'sstergiou',
            backgroundColor: 'rgba(36,122,219,0.1)',
            borderColor: 'rgba(36,122,219,0.2)',
            fill: true,
            data: [countDays(sst,func_m6), countDays(sst,func_m5), countDays(sst,func_m4), countDays(sst,func_m3), countDays(sst,func_m2), countDays(sst,func_m1), countDays(sst,func_m0)]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            color: 'transparent',
            zeroLineColor: 'transparent'
          },
          ticks: {
            fontSize: 2,
            fontColor: 'transparent'
          }
        }],
        yAxes: [{
          display: false,
          ticks: {
            display: false,
            suggestedMax: maxY
          }
        }]
      },
      elements: {
        line: {
          tension: 0.4,
          borderWidth: 3
        },
        point: {
          radius: 0,
          hitRadius: 10,
          hoverRadius: 4,
          hoverBorderWidth: 3
        }
      },
      layout: {
        padding: {
          top: 10
        }
      }

    }
    });
  }

    },
    error: function (err) {
      console.log('Error', err);
    },
    dataType:"json"
  });


  $.ajax({
    url: 'api?completedLine1=1',
    success: function (data) {

      var sstCount = 0;
      var aliCount = 0;
      var fwaCount = 0;

      var arrayLength = data.length;
      for (var i = 0; i < arrayLength; i++) {
          if (data[i]['bearbeitetvon'] == 'sstergiou') {
            sstCount++;
          } else if (data[i]['bearbeitetvon'] == 'alissitsin') {
            aliCount++;
          } else if (data[i]['bearbeitetvon'] == 'fwaleska') {
            fwaCount++;
          }
      }
      $('.fwaCounter').text(fwaCount);
      $('.aliCounter').text(aliCount);
      $('.sstCounter').text(sstCount);

      // Line Chart
      // Labels + Dates
      var DateTime = luxon.DateTime;
      var topDay = (data[0]['day']);
      var topDay = DateTime.fromISO(topDay);
      var topDayStr = topDay.toFormat('LLL dd');
      var comp_today = DateTime.local();
      var comp_todayStr = DateTime.local().toFormat('ccc LLL dd');
    
      var comp_m1 = comp_today.minus({days: 1}).toFormat('ccc LLL dd');
      var comp_m2 = comp_today.minus({days: 2}).toFormat('ccc LLL dd');
      var comp_m3 = comp_today.minus({days: 3}).toFormat('ccc LLL dd');
      var comp_m4 = comp_today.minus({days: 4}).toFormat('ccc LLL dd');
      var comp_m5 = comp_today.minus({days: 5}).toFormat('ccc LLL dd');
      var comp_m6 = comp_today.minus({days: 6}).toFormat('ccc LLL dd');
      var comp_m7 = comp_today.minus({days: 7}).toFormat('ccc LLL dd');
      var comp_m8 = comp_today.minus({days: 8}).toFormat('ccc LLL dd');
      var comp_m9 = comp_today.minus({days: 9}).toFormat('ccc LLL dd');
      var comp_m10 = comp_today.minus({days: 10}).toFormat('ccc LLL dd');
      var comp_m11 = comp_today.minus({days: 11}).toFormat('ccc LLL dd');
      var comp_m12 = comp_today.minus({days: 12}).toFormat('ccc LLL dd');
      var comp_m13 = comp_today.minus({days: 13}).toFormat('ccc LLL dd');

      // date formats for comparing in array
      var func_m0 = DateTime.local().toISODate();
      var func_m1 = comp_today.minus({days: 1}).toISODate();
      var func_m2 = comp_today.minus({days: 2}).toISODate();
      var func_m3 = comp_today.minus({days: 3}).toISODate();
      var func_m4 = comp_today.minus({days: 4}).toISODate();
      var func_m5 = comp_today.minus({days: 5}).toISODate();
      var func_m6 = comp_today.minus({days: 6}).toISODate();
      var func_m7 = comp_today.minus({days: 7}).toISODate();
      var func_m8 = comp_today.minus({days: 8}).toISODate();
      var func_m9 = comp_today.minus({days: 9}).toISODate();
      var func_m10 = comp_today.minus({days: 10}).toISODate();
      var func_m11 = comp_today.minus({days: 11}).toISODate();
      var func_m12 = comp_today.minus({days: 12}).toISODate();
      var func_m13 = comp_today.minus({days: 13}).toISODate();

      var count_d0 = 0;
      var count_d1 = 0;
      var count_d2 = 0;
      var count_d3 = 0;
      var count_d4 = 0;
      var count_d5 = 0;
      var count_d6 = 0;
      var count_d7 = 0;
      var count_d8 = 0;
      var count_d9 = 0;
      var count_d10 = 0;
      var count_d11 = 0;
      var count_d12 = 0;
      var count_d13 = 0;

      for (var e = 0; e < arrayLength; e++) {
        if (data[e]['day'] == func_m0) {
          count_d0++;
        } else if (data[e]['day'] == func_m1) {
          count_d1++;
        } else if (data[e]['day'] == func_m2) {
          count_d2++;
        } else if (data[e]['day'] == func_m3) {
          count_d3++;
        } else if (data[e]['day'] == func_m4) {
          count_d4++;
        } else if (data[e]['day'] == func_m5) {
          count_d5++;
        } else if (data[e]['day'] == func_m6) {
          count_d6++;
        } else if (data[e]['day'] == func_m7) {
          count_d7++;
        } else if (data[e]['day'] == func_m8) {
          count_d8++;
        } else if (data[e]['day'] == func_m9) {
          count_d9++;
        } else if (data[e]['day'] == func_m10) {
          count_d10++;
        } else if (data[e]['day'] == func_m11) {
          count_d11++;
        } else if (data[e]['day'] == func_m12) {
          count_d12++;
        } else if (data[e]['day'] == func_m13) {
          count_d13++;
        }
      }

      new Chart(document.getElementById("line-chart"), {
      type: 'bar',
      data: {
        labels: [comp_m13,comp_m12,comp_m11,comp_m10,comp_m9,comp_m8,comp_m7,comp_m6,comp_m5,comp_m4,comp_m3,comp_m2,comp_m1,comp_todayStr],
        datasets: [{ 
            data: [count_d13,count_d12,count_d11,count_d10,count_d9,count_d8,count_d7,count_d6,count_d5,count_d4,count_d3,count_d2,count_d1,count_d0],
            borderColor: "#fff",
            backgroundColor: "rgba(255,255,255,0.3)",
            pointHoverBackgroundColor: '#fff',
            fill: false,
            borderWidth: 2
          }]
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines: {
              color: 'transparent',
              zeroLineColor: 'transparent'
            },
            ticks: {
              fontSize: 2,
              fontColor: 'transparent'
            },
            // categoryPercentage: 0.5,
            // barPercentage: 1.0
            barThickness: 'flex'
          }],
          yAxes: [{
            display: false,
            ticks: {
              display: false
            }
          }]
        },
        elements: {
          line: {
            tension: 0.4,
            borderWidth: 3
          },
          point: {
            radius: 0,
            hitRadius: 10,
            hoverRadius: 4,
            hoverBorderWidth: 3
          }
        }
      }
    });

  /*******************************
   * doughnut chart 1 - Felix
   *******************************/

    new Chart(document.getElementById("doughnutchart1"), {
      type: 'doughnut',
      data: {
        labels: ["Felix",""],
        datasets: [
          {
            label: "Completed by Felix",
            backgroundColor: ["rgba(103,178,70,0.4)", "rgba(0,0,0,0.1)"],
            borderWidth: 0,
            data: [fwaCount,arrayLength-fwaCount]
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: {
          display: false
        },
        tooltips: {
          custom : function(tooltipModel) {
            tooltipModel.opacity = 0;
           },
           display: false
        },
        cutoutPercentage: 70,
        animationEasing : "easeOutBounce",
        animateRotate : true,
        animateScale : false,
      }
    });

  /*******************************
   * doughnut chart 2 - Andreas
   *******************************/

    new Chart(document.getElementById("doughnutchart2"), {
      type: 'doughnut',
      data: {
        labels: ["Andreas",""],
        datasets: [
          {
            label: "Completed by Andreas",
            backgroundColor: ["rgba(249,103,103,0.4)", "rgba(0,0,0,0.1)"],
            borderWidth: 0,
            data: [aliCount,arrayLength-aliCount]
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: {
          display: false
        },
        tooltips: {
          custom : function(tooltipModel) {
            tooltipModel.opacity = 0;
           },
           display: false
        },
        cutoutPercentage: 70,
        animationEasing : "easeOutBounce",
        animateRotate : true,
        animateScale : false,
      }
    });

  /*******************************
   * doughnut chart 3 - Stelios
   *******************************/

    new Chart(document.getElementById("doughnutchart3"), {
      type: 'doughnut',
      data: {
        labels: ["Stelios",""],
        datasets: [
          {
            label: "Completed by Stelios",
            backgroundColor: ["rgba(36,122,219,0.4)", "rgba(0,0,0,0.1)"],
            borderWidth: 0,
            data: [sstCount,arrayLength-sstCount]
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        legend: {
          display: false
        },
        tooltips: {
          custom : function(tooltipModel) {
            tooltipModel.opacity = 0;
           },
           display: false
        },
        cutoutPercentage: 70,
        animationEasing : "easeOutBounce",
        animateRotate : true,
        animateScale : false,
      }
    });

    },
    error: function (err) {
      console.log('Error', err);
    },
    dataType:"json"
  });


  /*******************************
   * Custom Tooltips - Chart.js
   *******************************/

  function CustomTooltips(tooltipModel) {
    var _this = this;
  
    // Add unique id if not exist
    var _setCanvasId = function _setCanvasId() {
      var _idMaker = function _idMaker() {
        var _hex = 16;
        var _multiplier = 0x10000;
        return ((1 + Math.random()) * _multiplier | 0).toString(_hex);
      };
  
      var _canvasId = "_canvas-" + (_idMaker() + _idMaker());
  
      _this._chart.canvas.id = _canvasId;
      return _canvasId;
    };
  
    var ClassName = {
      ABOVE: 'above',
      BELOW: 'below',
      CHARTJS_TOOLTIP: 'chartjs-tooltip',
      NO_TRANSFORM: 'no-transform',
      TOOLTIP_BODY: 'tooltip-body',
      TOOLTIP_BODY_ITEM: 'tooltip-body-item',
      TOOLTIP_BODY_ITEM_COLOR: 'tooltip-body-item-color',
      TOOLTIP_BODY_ITEM_LABEL: 'tooltip-body-item-label',
      TOOLTIP_BODY_ITEM_VALUE: 'tooltip-body-item-value',
      TOOLTIP_HEADER: 'tooltip-header',
      TOOLTIP_HEADER_ITEM: 'tooltip-header-item'
    };
    var Selector = {
      DIV: 'div',
      SPAN: 'span',
      TOOLTIP: (this._chart.canvas.id || _setCanvasId()) + "-tooltip"
    };
    var tooltip = document.getElementById(Selector.TOOLTIP);
  
    if (!tooltip) {
      tooltip = document.createElement('div');
      tooltip.id = Selector.TOOLTIP;
      tooltip.className = ClassName.CHARTJS_TOOLTIP;
  
      this._chart.canvas.parentNode.appendChild(tooltip);
    } // Hide if no tooltip
  
  
    if (tooltipModel.opacity === 0) {
      tooltip.style.opacity = 0;
      return;
    } // Set caret Position
  
  
    tooltip.classList.remove(ClassName.ABOVE, ClassName.BELOW, ClassName.NO_TRANSFORM);
  
    if (tooltipModel.yAlign) {
      tooltip.classList.add(tooltipModel.yAlign);
    } else {
      tooltip.classList.add(ClassName.NO_TRANSFORM);
    } // Set Text
  
  
    if (tooltipModel.body) {
      var titleLines = tooltipModel.title || [];
      var tooltipHeader = document.createElement(Selector.DIV);
      tooltipHeader.className = ClassName.TOOLTIP_HEADER;
      titleLines.forEach(function (title) {
        var tooltipHeaderTitle = document.createElement(Selector.DIV);
        tooltipHeaderTitle.className = ClassName.TOOLTIP_HEADER_ITEM;
        tooltipHeaderTitle.innerHTML = title;
        tooltipHeader.appendChild(tooltipHeaderTitle);
      });
      var tooltipBody = document.createElement(Selector.DIV);
      tooltipBody.className = ClassName.TOOLTIP_BODY;
      var tooltipBodyItems = tooltipModel.body.map(function (item) {
        return item.lines;
      });
      tooltipBodyItems.forEach(function (item, i) {
        var tooltipBodyItem = document.createElement(Selector.DIV);
        tooltipBodyItem.className = ClassName.TOOLTIP_BODY_ITEM;
        var colors = tooltipModel.labelColors[i];
        var tooltipBodyItemColor = document.createElement(Selector.SPAN);
        tooltipBodyItemColor.className = ClassName.TOOLTIP_BODY_ITEM_COLOR;
        tooltipBodyItemColor.style.backgroundColor = colors.backgroundColor;
        tooltipBodyItem.appendChild(tooltipBodyItemColor);
  
        if (item[0].split(':').length > 1) {
          var tooltipBodyItemLabel = document.createElement(Selector.SPAN);
          tooltipBodyItemLabel.className = ClassName.TOOLTIP_BODY_ITEM_LABEL;
          tooltipBodyItemLabel.innerHTML = item[0].split(': ')[0];
          tooltipBodyItem.appendChild(tooltipBodyItemLabel);
          var tooltipBodyItemValue = document.createElement(Selector.SPAN);
          tooltipBodyItemValue.className = ClassName.TOOLTIP_BODY_ITEM_VALUE;
          tooltipBodyItemValue.innerHTML = item[0].split(': ').pop();
          tooltipBodyItem.appendChild(tooltipBodyItemValue);
        } else {
          var _tooltipBodyItemValue = document.createElement(Selector.SPAN);
  
          _tooltipBodyItemValue.className = ClassName.TOOLTIP_BODY_ITEM_VALUE;
          _tooltipBodyItemValue.innerHTML = item[0];
          tooltipBodyItem.appendChild(_tooltipBodyItemValue);
        }
  
        tooltipBody.appendChild(tooltipBodyItem);
      });
      tooltip.innerHTML = '';
      tooltip.appendChild(tooltipHeader);
      tooltip.appendChild(tooltipBody);
    }
  
    var positionY = this._chart.canvas.offsetTop;
    var positionX = this._chart.canvas.offsetLeft; // Display, position, and set styles for font
  
    tooltip.style.opacity = 1;
    tooltip.style.left = positionX + tooltipModel.caretX + "px";
    tooltip.style.top = positionY + tooltipModel.caretY + "px";
  }