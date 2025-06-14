<?php

include_once 'connectdb.php';
session_start();

if ($_SESSION['useremail'] == "") {
    header('location:../index.php');
}

include_once "header.php";

$select = $pdo->prepare("select sum(total) as gt , count(invoice_id) as invoice from tbl_invoice");
$select->execute();

$row = $select->fetch(PDO::FETCH_OBJ);

$total_order = $row->invoice;
$grand_total = $row->gt;

$select = $pdo->prepare("select count(product) as pname from tbl_product");
$select->execute();

$row = $select->fetch(PDO::FETCH_OBJ);

$total_product = $row->pname;

$select = $pdo->prepare("select count(category) as cate from tbl_category");
$select->execute();

$row = $select->fetch(PDO::FETCH_OBJ);

$total_category = $row->cate;

?>

<!-- ChartJS -->
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header. Page header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li> -->
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo $total_order; ?></h3>
                                    <p>TOTAL INVOICE</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo number_format($grand_total, 2); ?></h3>
                                    <p>TOTAL REVENUE(INR)</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo $total_product; ?></h3>
                                    <p>TOTAL PRODUCT</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo $total_category; ?></h3>
                                    <p>TOTAL CATEGORY</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                    <div class="card card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Earning By Date</h5>
                        </div>
                        <div class="card-body">
                            <?php

                            $select = $pdo->prepare("select order_date , total  from tbl_invoice  group by order_date LIMIT 50");
                            $select->execute();

                            $ttl = [];
                            $date = [];

                            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);

                                $ttl[] = $total;
                                $date[] = $order_date;
                            }

                            // echo json_encode($total);

                            ?>
                            <div>
                                <canvas id="myChart" style="height: 250px"></canvas>
                            </div>
                        </div>

                        <script>
                            const ctx = document.getElementById('myChart');

                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($date); ?>,
                                    datasets: [{
                                        label: 'Total Earning',
                                        backgroundColor: 'rgb(21, 146, 218)',
                                        borderColor: 'rgb(21,146,218)',
                                        data: <?php echo json_encode($ttl); ?>,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline">
                        <div class="card-header">
                            <h5 class="m-0">BEST SELLING PRODUCT</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover " id="table_bestsellingproduct">
                                <thead>
                                    <tr>
                                        <td>Product ID</td>
                                        <td>Product Name</td>
                                        <td>QTY</td>
                                        <td>rate</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $select = $pdo->prepare("select product_id,product_name,rate,sum(qty) as q , sum(saleprice) as total from tbl_invoice_details group by product_id order by sum(qty) DESC LIMIT 10");
                                    $select->execute();

                                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                                        echo '
                                            <tr>
                                                <td>' . $row->product_id . '</td>
                                                <td style="font-size: 20px;"><span class="badge">' . $row->product_name . '</td></span>
                                                <td style="font-size: 20px;"><span class="badge">' . $row->q . '</td></span>
                                                <td style="font-size: 20px;"><span class="badge">' . $row->rate . '</td>
                                                <td style="font-size: 20px;"><span class="badge">' . $row->total . '</td>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-outline">
                        <div class="card-header">
                            <h5 class="m-0">Earning By Date</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-hover " id="table_recentorder">
                                <thead>
                                    <tr>
                                        <td>Invoice ID</td>
                                        <td>Order Date</td>
                                        <td>Total</td>
                                        <td>Payment Type</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $select = $pdo->prepare("select * from tbl_invoice  order by invoice_id DESC LIMIT 30");
                                    $select->execute();

                                    while ($row = $select->fetch(PDO::FETCH_OBJ)) {

                                        echo '
                                            <tr>
                                                <td style="font-size: 20px;"><span class="badge">'. $row->invoice_id . '</td></span>
                                                <td style="font-size: 20px;"><span class="badge">' . $row->order_date . '</td></span>
                                                <td style="font-size: 20px;"><span class="badge">' . $row->total . '</td>';

                                        if ($row->payment_type == "Cash") {
                                            echo '<td style="font-size: 20px;"><span class="badge">' . $row->payment_type . '</td></span></td>';
                                        } else if ($row->payment_type == "Card") {
                                            echo '<td style="font-size: 20px;"><span class="badge">' . $row->payment_type . '</td></span></td>';
                                        } else {
                                            echo '<td style="font-size: 20px;"><span class="badge">' . $row->payment_type . '</td></span></td>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include_once "footer.php";

?>

<script>
    $(document).ready(function () {
        $('#table_recentorder').DataTable({
            "order": [[0, "desc"]]
        });
        $('#table_bestsellingproduct').DataTable(); // Added initialization for Best Selling Product table
    });
</script>