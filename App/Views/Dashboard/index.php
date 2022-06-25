{% extends "dash_base.php" %}

{% block title %}
الرئيسية
{% endblock %}

{% block body %}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">الرئيسية</li>
                        <li class="breadcrumb-item"><a href="../Dashboard/index">الرئيسية</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" >
        <div class="container-fluid">
            <div class="row">



                <!-- /. tools -->
            <!-- Small boxes (Stat box) -->
                <div class="col-lg-6  col-sm-12 col-md-12">
                    <div class="clock" id="clock"> </div>
                </div>
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">
                    <!-- Map card -->
                    <div class="card bg-gradient-primary" style="display: none">
                        <!-- /.card-body-->
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div id="sparkline-1"></div>
                                </div>
                                <!-- ./col -->
                                <div class="col-4 text-center">
                                    <div id="sparkline-2"></div>
                                </div>
                                <!-- ./col -->
                                <div class="col-4 text-center">
                                    <div id="sparkline-3"></div>
                                </div>
                                <!-- ./col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.card -->


                    <!-- Calendar -->
                    <div class="card bg-gradient-light">
                        <div class="card-header border-0">

                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                التقويم
                            </h3>
                            <!-- tools card -->
                            <div class="card-tools">
                                <!-- button with a dropdown -->
                                <button type="button" class="btn btn-outline-dark btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    
                                </button>

                            </div>
                            <!-- /. tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <!--The calendar -->
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->


            </div>
            {% if getPermission.st =='1' %}

            <div class="row" dir="rtl">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="../employees/report">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{stats.emp}}</h3>

                            <p>موظف</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="../departments/report">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{stats.dep}}</h3>

                            <p>إدارة</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <a href="../work_places/report">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{stats.work}}</h3>

                            <p>موقع عمل</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    </a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                      <a href="#">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>IT</h3>
                            <p>
                                دعم فني
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-phone"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            {% endif %}
            <!-- /.row -->
            <!-- Main row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script>
    $("#main").last().addClass("active");
</script>
{% endblock %}
