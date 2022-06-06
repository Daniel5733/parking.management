<?php 
include_once('config/DB.php');
atualizarPecoTickets();
?>
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Faturação</span>
        <span class="info-box-number" id="pagamentos_hoje">0 kz</span>
        </div>
    </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Espaço Livres</span>
        <span class="info-box-number" id="espaco_livre">0</span>
        </div>
    </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Nº de Entradas</span>
        <span class="info-box-number" id="entradas_hoje">0</span>
        </div>
    </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Nº de Saídas</span>
        <span class="info-box-number" id="saidas_hoje">0</span>
        </div>
    </div>
    </div>
    <div class="col-md-6 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-info"><i class="far fa-copy"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Média de Faturação nas Ultimas 3 horas </span>
        <span class="info-box-number" id="ultimas3Horas">0 kz</span>
        </div>
    </div>
    </div>
    <div class="col-md-6 col-sm-6 col-12">
    <div class="info-box">
        <span class="info-box-icon bg-success"><i class="far fa-star"></i></span>
        <div class="info-box-content">
        <span class="info-box-text">Previsão de Faturação da Proxima hora</span>
        <span class="info-box-number" id="previsaoFaturacao">0</span>
        </div>
    </div>
    </div>    
</div>
<div class="row">
    <div class="col-md-6 demo-container">
        <div class="card card-info">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">Faturação / Ultimos 7 Dias</h3>
            </div>
            <div class="card-body">
                <div class="chart-demo">
                    <div id="chart1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 demo-container">
        <div class="card card-info">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">Faturação Mensal / Ultimos 12 Mesês</h3>
            </div>
            <div class="card-body">
                <div class="chart-demo">
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 demo-container">
        <div class="card card-info">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">Faturação / Ultimos 30 dias</h3>
            </div>
            <div class="card-body">
                <div class="chart-demo">
                    <div id="chart3"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 demo-container">
        <div class="card card-info">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">Entradas por Hora / Ultimos 30 dias</h3>
            </div>
            <div class="card-body">
                <div class="chart-demo">
                    <div id="chart4"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $.ajax({
        method: "GET",
        url: "./DashboardAPI/topo.php",
        data: {}
    })
    .done(function(result) {
        $("#pagamentos_hoje").empty().text(result.pagamento_hoje + ' Kz');
        $("#espaco_livre").empty().text(result.espaco_livre);
        $("#entradas_hoje").empty().text(result.entradas_hoje);
        $("#saidas_hoje").empty().text(result.saidas_hoje);
        $("#ultimas3Horas").empty().text(result.ultimas3Horas + ' Kz');
        $("#previsaoFaturacao").empty().text(result.previsaoFaturacao + ' Kz');
    });
});

</script> 
<script>
$(() => {
    $.ajax({
        method: "GET",
        url: "./DashboardAPI/grafico.php",
        data: {}
    })
    .done(function(result) {
        $('#chart1').dxChart({
            dataSource: result.g1.grafico,
            series: {
            argumentField: 'dia',
            valueField: 'valor',
            name: result.g1.faturacao_hoje + ' Kz',
            type: 'bar',
            color: '#17A2B8',
            },
            tooltip: {
                enabled: true,
                location: 'edge',
                customizeTooltip(arg) {
                    return {
                    text: `${arg.valueText} Kz`,
                    };
                },
            }
        });
        $('#chart2').dxChart({
            dataSource: result.g2.grafico,
            series: {
            argumentField: 'mes',
            valueField: 'valor',
            name: result.g2.faturacao_mes + ' Kz',
            type: 'bar',
            color: '#17A2B8',
            },
            tooltip: {
                enabled: true,
                location: 'edge',
                customizeTooltip(arg) {
                    return {
                    text: `${arg.valueText} Kz`,
                    };
                },
            }
        });
        $('#chart3').dxChart({
            dataSource: result.g3,
            series: {
            argumentField: 'dia',
            valueField: 'valor',
            type: 'line',
            color: '#17A2B8',
            name: ' '
            },
            tooltip: {
                enabled: true,
                location: 'edge',
                customizeTooltip(arg) {
                    return {
                    text: `${arg.valueText} Kz`,
                    };
                },
            }
        });
        $('#chart4').dxPieChart({
            type: 'doughnut',
            palette: 'Soft Pastel',
            dataSource: result.g4,
            tooltip: {
            enabled: true,
            customizeTooltip(arg) {
                return {
                text: `${arg.valueText} - ${(arg.percent * 100).toFixed(2)}%`,
                };
            },
            },
            legend: {
            horizontalAlignment: 'right',
            verticalAlignment: 'top',
            margin: 0,
            },
            export: {
            enabled: false,
            },
            series: [{
            argumentField: 'hora',
            label: {
                visible: false,
                connector: {
                visible: true,
                },
            },
            }],
        });
    });
  
});
</script> 