/**
 * Dashboard Analytics — PTSP
 * Adapted from full-version dashboards-analytics.js
 */

'use strict';

(function () {
  let cardColor, headingColor, fontFamily, labelColor;
  cardColor    = config.colors.cardColor;
  labelColor   = config.colors.textMuted;
  headingColor = config.colors.headingColor;
  fontFamily   = config.colors.fontFamily || 'inherit';

  // ─── Average Daily Permohonan (Sparkline Area) ──────────────────────────
  const averageDailySalesEl = document.querySelector('#averageDailySales');
  const averageDailySalesData = window.chartDailyData || [0, 0, 0, 0, 0, 0, 0];

  const averageDailySalesConfig = {
    chart: {
      height: 120,
      type: 'area',
      toolbar: { show: false },
      sparkline: { enabled: true }
    },
    markers: {
      colors: 'transparent',
      strokeColors: 'transparent'
    },
    grid: { show: false },
    colors: ['#059669'],
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.45,
        gradientToColors: [cardColor],
        opacityTo: 0.05,
        stops: [0, 100]
      }
    },
    dataLabels: { enabled: false },
    stroke: {
      width: 2.5,
      curve: 'smooth'
    },
    series: [{ name: 'Permohonan', data: averageDailySalesData }],
    xaxis: {
      show: true,
      lines: { show: false },
      labels: { show: false },
      stroke: { width: 0 },
      axisBorder: { show: false }
    },
    yaxis: {
      stroke: { width: 0 },
      show: false
    },
    tooltip: {
      enabled: true,
      theme: 'light',
      y: {
        formatter: (val) => val + ' permohonan'
      },
      x: { show: false }
    },
    responsive: [
      {
        breakpoint: 1387,
        options: { chart: { height: 90 } }
      },
      {
        breakpoint: 1200,
        options: { chart: { height: 130 } }
      }
    ]
  };

  if (averageDailySalesEl) {
    const averageDailySales = new ApexCharts(averageDailySalesEl, averageDailySalesConfig);
    averageDailySales.render();
  }



  // ─── Tracker Penyelesaian (Radial Bar) ──────────────────────────────────
  const supportTrackerEl = document.querySelector('#supportTracker');
  const supportTrackerRate = window.chartCompletionRate || 0;

  const supportTrackerOptions = {
    series: [supportTrackerRate],
    labels: ['Tingkat Selesai'],
    chart: {
      height: 280,
      type: 'radialBar'
    },
    plotOptions: {
      radialBar: {
        offsetY: 5,
        startAngle: -140,
        endAngle: 130,
        hollow: {
          size: '62%'
        },
        track: {
          background: cardColor,
          strokeWidth: '100%'
        },
        dataLabels: {
          name: {
            offsetY: -20,
            color: labelColor,
            fontSize: '13px',
            fontWeight: '500',
            fontFamily: fontFamily
          },
          value: {
            offsetY: 10,
            color: headingColor,
            fontSize: '36px',
            fontWeight: '700',
            fontFamily: fontFamily,
            formatter: (val) => val + '%'
          }
        }
      }
    },
    colors: ['#059669'],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        shadeIntensity: 0.4,
        gradientToColors: ['#047857'],
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 0.8,
        stops: [0, 100]
      }
    },
    stroke: {
      dashArray: 8
    },
    grid: {
      padding: {
        top: -15,
        bottom: 0
      }
    },
    states: {
      hover: { filter: { type: 'none' } },
      active: { filter: { type: 'none' } }
    },
    responsive: [
      {
        breakpoint: 992,
        options: { chart: { height: 260 } }
      },
      {
        breakpoint: 768,
        options: { chart: { height: 230 } }
      }
    ]
  };

  if (supportTrackerEl) {
    const supportTracker = new ApexCharts(supportTrackerEl, supportTrackerOptions);
    supportTracker.render();
  }

})();
