<?php
  $gerencias = $bd->getGerencias();
  foreach ($gerencias as $ger) {
    $ids[]       = $ger['id'];
    $labels[]    = $ger['des'];
    $promedios[] = $bd->getPromedioGerencias($ger['id'])['promedio'];
  }
?>
<div class="content-wrapper px-4">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-12">
          <h2 class="m-0 fw-bold">Resumen por gerencia</h2>
          <p class="text-secondary">Graficas de resultados</p>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Resumen Promedio de Evaluaciones por Gerencias</h3>
  
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
  
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Resumen Promedio de Evaluaciones por Gerencias</h3>
      
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <canvas id="donutChart" style="min-height: 450px; height: 450px; max-height: 450px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
  let labels    = <?php echo json_encode($labels) ?>;
  let promedios = <?php echo json_encode($promedios) ?>;
  let ids       = <?php echo json_encode($ids) ?>;

  var data = {
    labels: labels,
    datasets: [
      {
        data: promedios,
        backgroundColor: ['#6495ED', '#00a65a', '#f39c12', '#00c0ef', '#FA8072', '#d2d6de', '#98FB98', '#y3d0ac', '#c4f6da', '#99a65a', '#4682B4', '#9ACD32', '#ffff00', '#ffff00'],
      }
    ]
  }

  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  var donutOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }

  var donutChart = new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: data,
    options: donutOptions
  })

  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieOptions = {
    maintainAspectRatio: false,
    responsive: true,
  }
  var pieChart = new Chart(pieChartCanvas, {
    type: 'pie',
    data: data,
    options: pieOptions
  })

  $('#pieChart').click(
    function(event) {
      var activepoints = pieChart.getElementsAtEvent(event);
      if (activepoints.length > 0) {
        var clikedIndex = activepoints[0]["_index"];
        var actual_coord = pieChart.data.labels[clikedIndex];
        window.location.href = 'grafico_resumen_div.php?nivel_org=' + ids[clikedIndex];
      }
    }
  )

  $(document).ready(function() {
  })
</script>