<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-90680653-2"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-90680653-2');
  </script>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Meta -->
  <meta name="description" content="Association des Transporteurs des Personnes au Rwanda (ATPR).">
  <meta name="author" content="eric mugisha">

  <title>@yield('title') - {{ config('app.name', 'Association des Transporteurs des Personnes au Rwanda (ATPR).') }}</title>

  <!-- vendor css -->
  <link href="{{ asset('assets/src/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/src/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/src/lib/typicons.font/typicons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/src/lib/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/src/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/src/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/src/lib/select2/css/select2.min.css')}}" rel="stylesheet">
  <!-- azia CSS -->
  <link rel="stylesheet" href="{{ asset('assets/src/css/azia.css') }}">

</head>

<body>

  @include('layouts.header')

  <!-- End Header Top Area -->
  @include('sweetalert::alert')
  <!-- Main Menu area End-->
  <div class="az-content az-content-dashboard">
    @yield('content')
  </div>
  <!-- Start Footer area-->

  @include('layouts.footer')
  <!-- End Footer area-->

  <!-- <script src="{{ asset('assets/src/lib/jquery/jquery.min.js') }}"></script> -->
  <!-- <script src="{{ asset('assets/src/lib/bootstrap/js/bootstrap.min.js') }}"></script> -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script src="{{ asset('assets/src/lib/ionicons/ionicons.js') }}"></script>
  <script src="{{ asset('assets/src/lib/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/src/lib/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/src/lib/chart.js/Chart.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/src/lib/peity/jquery.peity.min.js') }}"></script>

  <script src="{{ asset('assets/src/js/jquery.cookie.js') }}" type="text/javascript"></script>
  <script src="{{ asset('assets/src/js/azia.js') }}"></script>
  <script src="{{ asset('assets/src/js/chart.flot.sampledata.js') }}"></script>
  <script src="{{ asset('assets/src/js/dashboard.sampledata.js') }}"></script>
  <script src="{{ asset('assets/src/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{ asset('assets/src/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
  <script src="{{ asset('assets/src/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{ asset('assets/src/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>
  <script src="{{ asset('assets/src/lib/select2/js/select2.min.js')}}"></script>
  <script>
    $(function() {
      'use strict'

      var plot = $.plot('#flotChart', [{
        data: flotSampleData3,
        color: '#007bff',
        lines: {
          fillColor: {
            colors: [{
              opacity: 0
            }, {
              opacity: 0.2
            }]
          }
        }
      }, {
        data: flotSampleData4,
        color: '#560bd0',
        lines: {
          fillColor: {
            colors: [{
              opacity: 0
            }, {
              opacity: 0.2
            }]
          }
        }
      }], {
        series: {
          shadowSize: 0,
          lines: {
            show: true,
            lineWidth: 2,
            fill: true
          }
        },
        grid: {
          borderWidth: 0,
          labelMargin: 8
        },
        yaxis: {
          show: true,
          min: 0,
          max: 100,
          ticks: [
            [0, ''],
            [20, '20K'],
            [40, '40K'],
            [60, '60K'],
            [80, '80K']
          ],
          tickColor: '#eee'
        },
        xaxis: {
          show: true,
          color: '#fff',
          ticks: [
            [25, 'OCT 21'],
            [75, 'OCT 22'],
            [100, 'OCT 23'],
            [125, 'OCT 24']
          ],
        }
      });

      $.plot('#flotChart1', [{
        data: dashData2,
        color: '#00cccc'
      }], {
        series: {
          shadowSize: 0,
          lines: {
            show: true,
            lineWidth: 2,
            fill: true,
            fillColor: {
              colors: [{
                opacity: 0.2
              }, {
                opacity: 0.2
              }]
            }
          }
        },
        grid: {
          borderWidth: 0,
          labelMargin: 0
        },
        yaxis: {
          show: false,
          min: 0,
          max: 35
        },
        xaxis: {
          show: false,
          max: 50
        }
      });

      $.plot('#flotChart2', [{
        data: dashData2,
        color: '#007bff'
      }], {
        series: {
          shadowSize: 0,
          bars: {
            show: true,
            lineWidth: 0,
            fill: 1,
            barWidth: .5
          }
        },
        grid: {
          borderWidth: 0,
          labelMargin: 0
        },
        yaxis: {
          show: false,
          min: 0,
          max: 35
        },
        xaxis: {
          show: false,
          max: 20
        }
      });


      //-------------------------------------------------------------//


      // Line chart
      $('.peity-line').peity('line');

      // Bar charts
      $('.peity-bar').peity('bar');

      // Bar charts
      $('.peity-donut').peity('donut');

      var ctx5 = document.getElementById('chartBar5').getContext('2d');
      new Chart(ctx5, {
        type: 'bar',
        data: {
          labels: [0, 1, 2, 3, 4, 5, 6, 7],
          datasets: [{
            data: [2, 4, 10, 20, 45, 40, 35, 18],
            backgroundColor: '#560bd0'
          }, {
            data: [3, 6, 15, 35, 50, 45, 35, 25],
            backgroundColor: '#cad0e8'
          }]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            enabled: false
          },
          legend: {
            display: false,
            labels: {
              display: false
            }
          },
          scales: {
            yAxes: [{
              gridLines: {
                display: false
              },
              display: false,
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                max: 80
              }
            }],
            xAxes: [{
              gridLines: {
                display: false
              },
              display: false,
              barPercentage: 0.6,
              gridLines: {
                color: 'rgba(0,0,0,0.08)'
              },
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                display: false
              }
            }]
          }
        }
      });

      // Donut Chart
      var datapie = {
        labels: ['Search', 'Email', 'Referral', 'Social', 'Other'],
        datasets: [{
          data: [25, 20, 30, 15, 10],
          backgroundColor: ['#6f42c1', '#007bff', '#17a2b8', '#00cccc', '#adb2bd']
        }]
      };

      var optionpie = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false,
        },
        animation: {
          animateScale: true,
          animateRotate: true
        }
      };

      // For a doughnut chart
      var ctxpie = document.getElementById('chartDonut');
      var myPieChart6 = new Chart(ctxpie, {
        type: 'doughnut',
        data: datapie,
        options: optionpie
      });

    });
  </script>

  <script>
    $(function() {
      'use strict'

      $('#example1').DataTable({
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      $('#example2').DataTable({
        responsive: true,
        language: {
          searchPlaceholder: 'Search...',
          sSearch: '',
          lengthMenu: '_MENU_ items/page',
        }
      });

      // Select2
      $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity
      });

    });
  </script>
</body>

<!-- Mirrored from demo.bootstrapdash.com/azia/src/template/dashboard-one.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 03 Dec 2025 17:11:29 GMT -->

</html>