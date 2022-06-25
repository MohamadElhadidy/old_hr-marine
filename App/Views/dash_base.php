<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../index_style/images/favicon.png" rel="icon">
    <title>{% block title %} {% endblock %}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    {% block style %}{% endblock %}


    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300" rel="stylesheet">


    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Select2 -->
    <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/foopicker.css">
    <script type="text/javascript" src="../assets/foopicker.js"></script>

    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sp-1.0.1/sl-1.3.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

    <script src="../assets/plugins/jquery/jquery.min.js"></script>

    <script>

    function createAlert(
        title,
        summary,
        details,
        severity,
        dismissible,
        autoDismiss,
        appendToId
    ) {
        var iconMap = {
            info: "fa fa-info-circle",
            success: "fa fa-thumbs-up",
            warning: "fa fa-exclamation-triangle",
            danger: "fa ffa fa-exclamation-circle"
        };

        var iconAdded = false;
        var alertClasses = ["alert", "animated", "flipInX"];
        alertClasses.push("alert-" + severity.toLowerCase());

        if (dismissible) {
            alertClasses.push("alert-dismissible");
        }

        var msgIcon = $("<i />", {
            class: iconMap[severity] // you need to quote "class" since it's a reserved keyword
        });

        var msg = $("<div />", {
            class: alertClasses.join(" ") // you need to quote "class" since it's a reserved keyword
        });

        if (title) {
            var msgTitle = $("<h4 />", {
                html: title
            }).appendTo(msg);

            if (!iconAdded) {
                msgTitle.prepend(msgIcon);
                iconAdded = true;
            }
        }

        if (summary) {
            var msgSummary = $("<strong />", {
                html: summary
            }).appendTo(msg);

            if (!iconAdded) {
                msgSummary.prepend(msgIcon);
                iconAdded = true;
            }
        }

        if (details) {
            var msgDetails = $("<p />", {
                html: details
            }).appendTo(msg);

            if (!iconAdded) {
                msgDetails.prepend(msgIcon);
                iconAdded = true;
            }
        }

        if (dismissible) {
            var msgClose = $("<span />", {
                class: "close", // you need to quote "class" since it's a reserved keyword
                "data-dismiss": "alert",
                html: "<i class='fa fa-times-circle'></i>"
            }).appendTo(msg);
        }

        $("#" + appendToId).prepend(msg);

        if (autoDismiss) {
            setTimeout(function() {
                msg.addClass("flipOutX");
                setTimeout(function() {
                    msg.remove();
                }, 1000);
            }, 5000);
        }
    }


</script>

    <style>
    #pageMessages {
        position: fixed;
        bottom: 5px;
        right: 5px;
        width: 30%;
        z-index: 9999;
    }

    .alert {
        position: relative;
    }

    .alert .close {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 1em;
    }

    .alert .fa {
        margin-right: 0.3em;
    }
    @media only screen and (max-width: 600px) {
        #pageMessages {
            width: 100%;
        }
    }
    .clock {
        background-color: #fffefa;
        color: #0569ff;
        position: relative;
        padding: 10px 20px;
        font-size: 40px;
        border-radius: 5px;
        left: 50%;
        transform: translateX(-50% );
        display: block;
        z-index: 999;
        text-align: center;
        width: 100%;
        margin-bottom: 15px;
    }
    select2-container .select2-selection--single .select2-selection__rendered {
        text-align: center;
        display: inline;
    }
    .form-group{
        text-align: center;
    }
    .datepicker > span:hover {
        cursor: pointer;
    }
    .card-title {
        float: none;
    }
    body{
        font-family: Lateef, serif;
        font-weight: bolder;
        -webkit-print-color-adjust:exact;


    }
    button.dt-button, div.dt-button, a.dt-button{
        background-color: #0a6ebd;
    }
    div.dataTables_wrapper {
        direction: rtl;
    }
    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }
    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }
    .img-delete {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }
    .img-delete:hover {
        background: white;
        color: black;
    }

    </style>
    <style>
    /*
@font-face {
  font-family: 'Montserrat';
  font-style: normal;
  font-weight: 700;
  src: local('Montserrat Bold'), local('Montserrat-Bold'), url(http://fonts.gstatic.com/s/montserrat/v14/JTURjIg1_i6t8kCHKm45_dJE3gnD-w.ttf) format('truetype');
}
@font-face {
  font-family: 'Roboto';
  font-style: normal;
  font-weight: 100;
  src: local('Roboto Thin'), local('Roboto-Thin'), url(http://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxIIzc.ttf) format('truetype');
}*/
@-webkit-keyframes animation-rotate {
  100% {
    -webkit-transform: rotate(360deg);
  }
}
@-moz-keyframes animation-rotate {
  100% {
    -moz-transform: rotate(360deg);
  }
}
@-o-keyframes animation-rotate {
  100% {
    -o-transform: rotate(360deg);
  }
}
@keyframes animation-rotate {
  100% {
    transform: rotate(360deg);
  }
}



.button:active {
  background-color: #258cd1;
  background-image: 8121991;
  background-image: -webkit-linear-gradient(#258cd1 0%, #258cd1 100%);
  background-image: -moz-linear-gradient(#258cd1 0%, #258cd1 100%);
  background-image: -o-linear-gradient(#258cd1 0%, #258cd1 100%);
  background-image: linear-gradient(#258cd1 0%, #258cd1 100%);
}
.button--loading {
  background-color: #258cd1 !important;
  background-image: 8121991 !important;
  background-image: -webkit-linear-gradient(#258cd1 0%, #258cd1 100%) !important;
  background-image: -moz-linear-gradient(#258cd1 0%, #258cd1 100%) !important;
  background-image: -o-linear-gradient(#258cd1 0%, #258cd1 100%) !important;
  background-image: linear-gradient(#258cd1 0%, #258cd1 100%) !important;
  position: relative;
  cursor: wait;
}
.button--loading:before {
  margin: -13px 0 0 -13px;
  width: 24px;
  height: 24px;
  position: absolute;
  left: 50%;
  top: 50%;
  content: "";
  -webkit-border-radius: 24px;
  -webkit-background-clip: padding-box;
  -moz-border-radius: 24px;
  -moz-background-clip: padding;
  border-radius: 24px;
  background-clip: padding-box;
  border: rgba(255, 255, 255, 0.25) 2px solid;
  border-top-color: #fff;
  -webkit-animation: animation-rotate 750ms linear infinite;
  -moz-animation: animation-rotate 750ms linear infinite;
  -o-animation: animation-rotate 750ms linear infinite;
  animation: animation-rotate 750ms linear infinite;
}
.button--loading span,
.button--loading:hover span,
.button--loading:active span {
  color: transparent;
  text-shadow: none;
}

</style>


    <script>
        $(document).ready(function(){

            function load_unseen_notification(view = '')
            {
                $.ajax({
                    url:"../notifications/notifications",
                    method:"POST",
                    data:{view:view},
                    dataType:"json",
                    success:function(data)
                    {
                        $('.dropdown_menu').html(data.notification);
                        if(data.unseen_notification > 0)
                        {
                            //$('.count').html(data.unseen_notification);
                        }
                    }
                });
            }

            load_unseen_notification();

            $(".notifications").click( function(){
                $('.count').html('');
                load_unseen_notification('yes');
            });

            setInterval(function(){
                load_unseen_notification();
            }, 10000);


   function load_online(view = '')
            {
                $.ajax({
                    url:"../Admin/onlineUsers",
                    method:"POST",
                    data:{view:view},
                    dataType:"json",
                    success:function(data)
                    {
                        $('.dropdown2_menu').html(data.online);
                        if(data.online_users > 0)
                        {
                            $('.count2').html(data.online_users);
                        }
                    }
                });
            }

            load_online();

            setInterval(function(){
                load_online();
            }, 10000);


        function online(view = '1') {
            $.ajax({
                url: "../notifications/online",
                method: "POST",
                data: {view: view}
            });
        }

        setInterval(function(){
            online();
        }, 10000);
        });
        
       function getCities(id,select_id){
           let cities = '';
           if(select_id == 'address')
           {
               cities = '#cities_address';
           }
           else if(select_id == 'place_of_birth')
           {
               cities = '#place_of_birth_cities';
           }
           $(cities).html("<option>جاري التحميل.....</option>");
           $.ajax({
               url: "../cities/get",
               method: "POST",
               data: {id: id},
               dataType: "json"
           })
               .done(function(data)
               {
                   $(cities).html(data.cities);

               });
       }

    </script>
    <style>
        label.error {
            color: #b30b08;
            margin-top: 2px;
            background-color: #ffe2e269;
            border-color: #5a101c00;
            padding: 3px 20px 1px 20px;
        }
    </style>
    <style>
        .box {
            position: relative;
            background: #ffffff;
            width: 100%;
        }

        .box-header {
            color: #444;
            display: block;
            padding: 15px;
            position: relative;
            border-bottom: 1px solid #f4f4f4;
            margin-bottom: 10px;
        }

        .box-tools {
            position: absolute;
            right: 10px;
            top: 5px;
        }

        .dropzone-wrapper {
            border: 2px dashed #91b0b3;
            color: #92b0b3;
            position: relative;
            height: 150px;
        }

        .dropzone-desc {
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            text-align: center;
            width: 40%;
            top: 50px;
            font-size: 16px;
        }
        .dropzone, .dropzone:focus {
            position: relative;
            outline: none !important;
            width: 100%;
            height: 150px;
            cursor: pointer;
            opacity: 0;
            z-index: 1;
        }


        .dropzone-wrapper:hover,
        .dropzone-wrapper.dragover {
            background: #ecf0f5;
        }

        .preview-zone {
            text-align: center;
        }

        .preview-zone .box {
            box-shadow: none;
            border-radius: 0;
            margin-bottom: 0;
        }
        div.dataTables_wrapper {
            direction: rtl;
        }

        button.dt-button.active {
            background: #2da7cc !important;
        }
        button.dt-button {
            background: #007bff !important;
            color: white !important;
            font-weight: bold !important;
        }
        ::placeholder {
            text-align: center;
        }
        input[type="search"],input[type="text"] {
            text-align: center;
            font-weight: bolder;
        }
        .jconfirm-box-container, .jconfirm-buttons{
           text-align: right;
        }
        .underline{
            color: black;
        }
        .setting_menu{
            list-style: none;
            float: right;
            text-align: center;
        }
        .setting_menu{
            list-style: none;
            float: right;
            text-align: center;
        }
        .setting_menu a:hover{
            color: lightseagreen;
            text-decoration: underline;
        }
        .user-panel img {
            width: 2.8rem;
        }
        os-theme-dark>.os-scrollbar>.os-scrollbar-track, .os-theme-light>.os-scrollbar>.os-scrollbar-track {
            background-color: black;
        }
        .font-weight-bolder {
            font-size: 15px;
        }
        .small-box>.inner {
            padding: 10px;
            color: #007bff;
        }
        .small-box .icon {
            color: rgb(0, 123, 255);
            z-index: 0;
        }
        h2{
            text-align: center;
            box-sizing: border-box;
            font-size: 25px;
            font-weight: bolder;
            border: 1px solid black;
            width: 50%;
            margin: 0px auto;
            margin-top: 5px;
        }
         table.dataTable th, table.dataTable td {
            text-align: center;
            font-weight: bolder;
             border-bottom-width: medium;
         }
        table.dataTable td{
            border: 1px solid black;
        }
        table.dataTable th {
            background-color: rgb(0, 123, 255);
            color: white;
            font-size : larger;
        }

        @media print {
            table.dataTable  {
                font-size : larger;
                border-bottom-width: medium;
            }
        }
        table.dataTable tbody tr.selected {
            background-color: #00a6a6 !important;
        }
        @media print {
            body
            {
                border-top: hidden;
                width: 100%;
                height: auto;
                -webkit-print-color-adjust:exact;
            }
            table.dataTable tbody tr.selected {
                background-color: #00a6a6 !important;
            }
            .selected {
                color: red;
            }

        }

    </style>
    {% block print%}
    {% endblock%}

</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

            <li class="nav-item d-none d-sm-inline-block">
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->

            <li class="nav-item dropdown" dir="rtl">
                {% if current_user.id == '29' or current_user.auth == '2' %}
                <a class="nav-link notifications" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-danger navbar-badge count">.</span>
                </a>
                {% endif %}
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown_menu"></div>

                </div>
            </li>
              <li class="nav-item dropdown2" dir="rtl">
                {% if current_user.id == '29' %}
                <a class="nav-link online" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-check"></i>
                    <span class="badge badge-danger navbar-badge count2"></span>
                </a>
                {% endif %}
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown2_menu"></div>

                </div>
            </li>

            <li class="nav-item dropdown" dir="rtl">
                <a class="nav-link setting" data-toggle="dropdown" href="#">
                    <i class="fas fa-cog"></i>
                    <span class="badge badge-danger navbar-badge "></span>
                </a>
                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                    <ul class="setting_menu">
                        {% if current_user.auth != '4' %}
                        <li><a href="../Companies/new">اختر الشركة</a></li>
                        {% endif %}
                        <li><a href="../Profile/my_profile">الحساب الشخصي</a></li>
                        <hr>
                        <li><a href="../Login/logout">تسجيل الخروج</a></li>
                    </ul>

                </div>
            </li>

            <!-- Notifications Dropdown Menu -->
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4 sidebar-light-primary">
        <!-- Brand Logo -->
        <a href="#" class="brand-link navbar-primary">
            <img src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            {% if current_user.auth == '4' %}
            <span class="brand-text font-weight-bolder">مسئول إدارة</span>
            {% else %}
            <span class="brand-text font-weight-bolder" style="color: white;">{{company.name_ar}}</span>
            {% endif %}
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="../{{current_user.personal_photo}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{current_user.name}}</a>
                </div>
            </div>
            <!-- Sidebar user panel (optional)
                         <div class="user-panel" style="margin: 0px auto;text-align: center;">
                    <div class="info" style="display: unset;">
                        <img src="../{{current_user.personal_photo}}" style="width: 90px;">
                        <a href="#" class="d-block">{{current_user.name}}</a>
                </div>
            </div>
-->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="../Dashboard/index" id="main" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الرئيسية
                            </p>
                        </a>
                    </li>

                    {% if current_user.id == '29' %}
                    <li class="nav-item has-treeview">
                        <a href="#" id="admin" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>  المستخدميين
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item has-treeview">
                                <a href="../Signup/new" id="admin_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>
                                        إنشاء حساب جديد
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="../admin/report" id="admin_report" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>
                                        الصلاحيات
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    {% endif %}
                    
                    {% if current_user.auth == '4' %}
                    <li class="nav-item has-treeview">
                        <a href="../departments/manager" id="departments_manager" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>   تقرير الإدارات
                            </p>
                        </a>
                    </li>
                    {% endif %}
                    {% if current_user.auth != '4' %}
                    {% if '1' in getPermission.ja   %}
                    <li  class="nav-item has-treeview">
                        <a href="#" id="job_application" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                            طلبات الإلتحاق
                                <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                                <ul class="nav nav-treeview">
                                    {% if '3' in getPermission.ja   %}
                                    <li class="nav-item has-treeview">
                                        <a href="../job_applications/new"  id="job_application_new" class="nav-link">
                                            <i class="nav-icon fas fa-plus-circle"></i>
                                            <p>طلب جديد
                                            </p>
                                        </a>
                                    </li>

                                    {% endif %}
                                    {% if '2' in getPermission.ja   %}
                                    <li class="nav-item ">
                                        <a href="../job_applications/report"  id="job_application_report" class="nav-link">
                                            <i class="nav-icon fas fa-receipt"></i>
                                            <p>طلبات الالتحاق</p>
                                        </a>
                                    </li>
                                    {% endif %}
                                </ul>
                            </li>
                    {% endif %}
                    {% if '1' in getPermission.em   %}
                    <li  class="nav-item has-treeview">
                        <a href="#" id="employees" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                الموظفيين
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                                <ul class="nav nav-treeview">
                                    {% if '3' in getPermission.em   %}
                                    <li class="nav-item has-treeview">
                                        <a href="../employees/new" id="employee_new" class="nav-link">
                                            <i class="nav-icon fas fa-plus-circle"></i>
                                            <p>إضافة  موظف
                                            </p>
                                        </a>
                                    </li>
                                    {% endif %}
                                    {% if '2' in getPermission.em   %}
                                    <li class="nav-item ">
                                        <a href="../employees/report" id="employee_report" class="nav-link">
                                            <i class="nav-icon fas fa-receipt"></i>
                                            <p> تقرير الموظفيين </p>
                                        </a>
                                    </li>
                                     <li class="nav-item ">
                                        <a href="../employees/armyReport" id="army_employee_report" class="nav-link">
                                            <i class="nav-icon fas fa-receipt"></i>
                                            <p> تقرير المجندين </p>
                                        </a>
                                    </li><li class="nav-item ">
                                        <a href="../employees/pensionReport" id="pension_employee_report" class="nav-link">
                                            <i class="nav-icon fas fa-receipt"></i>
                                            <p> تقرير المعاشات </p>
                                        </a>
                                    </li>
                                    {% endif %}
                                    {% if '2' in getPermission.em   %}
                                    <li class="nav-item ">
                                        <a href="../employees/attachments" id="employee_attachments" class="nav-link">
                                            <i class="nav-icon fas fa-receipt"></i>
                                            <p> تقرير المرفقات </p>
                                        </a>
                                    </li>
                                    {% endif %}
                                </ul>
                            </li>
                    {% endif %}
                    {% if '1' in getPermission.de   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="departments" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>  الادارات
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.de   %}
                            <li class="nav-item has-treeview">
                                <a href="../departments/new"  id="departments_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p> إضافة ادارة
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.de   %}
                            <li class="nav-item ">
                                <a href="../departments/report"  id="departments_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p> إدارات الشركة</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.jo   %}
                    <li  class="nav-item has-treeview">
                        <a href="#" id="jobs" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>  الوظائف
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.jo   %}
                            <li class="nav-item has-treeview">
                                <a href="../jobs/new"  id="jobs_new"  class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p> إضافة وظيفة
                                    </p>
                                </a>
                            </li>
                            {% endif %}

                            {% if '2' in getPermission.jo   %}
                            <li class="nav-item ">
                                <a href="../jobs/report" id="jobs_report"  class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p> الوظائف</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.wp   %}
                    <li   class="nav-item has-treeview">
                        <a href="#"  id="work_places" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>  مواقع العمل
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.wp   %}
                            <li class="nav-item has-treeview">
                                <a href="../work_places/new" id="work_places_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p> إضافة موقع عمل
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.wp   %}
                            <li class="nav-item ">
                                <a href="../work_places/report" id="work_places_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p> مواقع العمل</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.ins   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="insurances" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>   التأمينات
                                <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.ins   %}
                            <li class="nav-item has-treeview">
                                <a href="../insurances/new" id="insurances_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p> إضافة تأمين لموظف
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.ins   %}
                            <li class="nav-item ">
                                <a href="../insurances/report" id="insurances_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>سجل التأمينات</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.ho   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="holidays" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                الأجازات
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.ho   %}
                            <li class="nav-item has-treeview">
                                <a href="../holidays/new" id="holidays_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>
                                        إضافة أجازة لموظف
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.ho   %}
                            <li class="nav-item ">
                                <a href="../holidays/report" id="holidays_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>سجل أجازات</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.dr   %}
                    <li class="nav-item has-treeview">
                        <a href="#" id="drop" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>  انقطاع عن العمل
                                <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.dr   %}
                            <li class="nav-item has-treeview">
                                <a href="../Drop/new"  id="drop_new"class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>  إضافة إنقطاع لموظف
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.dr   %}
                            <li class="nav-item ">
                                <a href="../Drop/report" id="drop_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>   المنقطعين عن العمل </p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.pe   %}
                    <li  class="nav-item has-treeview">
                        <a href="#"  id="penalties" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>   الجزاءات
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.pe   %}
                            <li class="nav-item has-treeview">
                                <a href="../penalties/new"  id="penalties_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p> إضافة جزاء لموظف
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.pe   %}
                            <li class="nav-item ">
                                <a href="../penalties/report"  id="penalties_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>سجل الجزاءات</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.di   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="dismissals" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                إخلاء طرف
                                <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                                <ul class="nav nav-treeview">
                                    {% if '3' in getPermission.di   %}
                                    <li class="nav-item has-treeview">
                                        <a href="../Dismissal/new" id="dismissal_new" class="nav-link">
                                            <i class="nav-icon fas fa-plus-circle"></i>
                                            <p> إخلاء طرف
                                            </p>
                                        </a>
                                    </li>
                                    {% endif %}
                                    {% if '2' in getPermission.di   %}
                                    <li class="nav-item ">
                                        <a href="../Dismissal/report" id="dismissal_report" class="nav-link">
                                            <i class="nav-icon fas fa-receipt"></i>
                                            <p>   المخلي طرفهم</p>
                                        </a>
                                    </li>
                                    {% endif %}
                                </ul>
                            </li>
                    {% endif %}
                    {% if '1' in getPermission.fp   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="fingerprints" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>    البصمة 
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '1' in getPermission.fp   %}
                            {% set break = false %}
                                {% for Permission in getCompaniesPermission%}
                                {%  if   break == false %}
                                        {% if  Permission.company_id == 1%}
                                            <li class="nav-item has-treeview">
                                                <a href="http://192.168.168.11/fingerprints/"  class="nav-link">
                                                    <i class="nav-icon fas fa-plus-circle"></i>
                                                    <p>
                                                        مزامنة البصمة
                                                    </p>
                                                </a>
                                                </li>
                                                    {% set break = true %}
                                         {% elseif   Permission.company_id == 3 %}
                                            <li class="nav-item has-treeview">
                                                <a href="http://192.168.1.9/fingerprints/"  class="nav-link">
                                                    <i class="nav-icon fas fa-plus-circle"></i>
                                                    <p>
                                                        مزامنة البصمة
                                                    </p>
                                                </a>
                                                </li>
                                                        {% set break = true %}
                                        {% endif%}
                                {% endif%}
                                {% endfor%}
                            {% endif %}
                            {% if '6' in getPermission.fp   %}
                            <li class="nav-item ">
                                <a href="../fingerprints/report" id="fingerprints_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p> تقرير البصمة </p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.sa   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="salaries" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>   الرواتب و الأجور
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.sa   %}
                            <li class="nav-item has-treeview">
                                <a href="../salaries/new" id="salaries_new" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>
                                        تقرير مرتبات جديد
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.sa   %}
                            <li class="nav-item ">
                                <a href="../salaries/report" id="salaries_report" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p> التقارير السابقة</p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% if '1' in getPermission.te   %}
                    <li   class="nav-item has-treeview">
                        <a href="#" id="templates" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>   النماذج
                                <i class="fas fa-angle-left right"></i>
                                
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            {% if '3' in getPermission.te   %}
                            <li class="nav-item has-treeview">
                                <a href="../templates/new" id="templates_upload" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>رفع نموذج جديد
                                    </p>
                                </a>
                            </li>
                            {% endif %}
                            {% if '2' in getPermission.te   %}
                            <li class="nav-item ">
                                <a href="../templates/download" id="templates_download" class="nav-link">
                                    <i class="nav-icon fas fa-receipt"></i>
                                    <p>تحميل نموذج </p>
                                </a>
                            </li>
                            {% endif %}
                        </ul>
                    </li>
                    {% endif %}
                    {% endif %}
                </ul>

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    {% block body %}
    {% endblock %}
            <div id="pageMessages">

            </div>
    {% for message in flash_messages %}
<div id="pageMessages">

</div>
    <input id="click"  type="hidden" onclick="createAlert('',{{message.body}},'',{{message.type}},true,true,'pageMessages');" >
{% endfor %}
    <!-- Content Wrapper. Contains page content -->

    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong><a href="#">&copy; 5-2020 (V 2.0 )</a>.</strong>
      IT Department
        <!-- <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 2.0.0
       </div> -->
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->


<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Bootstrap 4 -->
        <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
        <!-- ChartJS -->
        <!-- Sparkline -->
        <script src="../assets/plugins/sparklines/sparkline.js"></script>
        <!-- JQVMap -->
       
        <!-- jQuery Knob Chart -->
        <script src="../assets/plugins/jquery-knob/jquery.knob.min.js"></script>
        <!-- daterangepicker -->
        <script src="../assets/plugins/moment/moment.min.js"></script>
        <script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <!-- Summernote -->
        <script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../assets/dist/js/adminlte.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="../assets/dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../assets/dist/js/demo.js"></script>

        <!-- bs-custom-file-input -->
        <script src="../assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
        <!-- Select2 -->
        <!-- Bootstrap4 Duallistbox -->
        <script src="../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

        <!-- bootstrap color picker -->

        <script src="../assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <!-- Bootstrap Switch -->
        <script src="../assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <!-- DataTables -->
        <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<script src="../assets/plugins/select2/js/select2.full.min.js"></script>
<script src="../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>


{% block footer%}
{% endblock%}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

        <!-- page script -->
<script>

    // Now call the functions one after the other using the done method
    $(function () {
        var title = document.title;
        var company ={{company.id}};
        var src ='../files/'+company+'.png';
        var table = $('#example1').DataTable( {
            paging: true,
            lengthChange: true,
            searching: true,
            fixedColumns:   true,
            ordering: true,
            autoWidth: false,
            responsive: true,
            select:true,
            AutoFill:true,
            lengthMenu: [
                [ 10, 25, 50, -1 ],

                ['<i class="fas fa-grip-lines" title="أظهر 10 صفوف"></i> 10 ','<i class="fas fa-grip-lines" title="أظهر25 صف"></i> 25 ','<i class="fas fa-grip-lines" title="أظهر 50 صف"></i> 50 ','<i class="fas fa-grip-lines" title="أظهر كل صفوف"></i> الكل ']


            ],
            colReorder: {
                realtime: true
            },
            dom: 'Bfrtip',
            buttons:[
                {
                    text: '<i class="fas fa-plus-circle" title="إضافة"></i>',
                    title: '',
                    action: function ( e, dt, button, config ) {
                        window.location = 'new';
                    }
                },
                {
                    extend: 'pageLength'

                } ,
                  {
                text: 'إجمالي',
                action: function ( e, dt, node, config ) {
                      alert(table.rows({ 'search': 'applied' }).count());
                }
                 },
                {

                    extend: 'excel',
                    text: '<i class="fas fa-file-excel" title="Excel sheet"></i>',
                    title: '',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            selected: null,
                        }
                    }
                },
                {
                    extend: 'print',
                    autoPrint: false,
                    title:'',
                    text: '<i class="fas fa-print" title="طباعه الكل"></i>',
                    messageTop: '<img src="'+src+'"style="width :100%;">'+'<br><h2>'+title+
                    '</h2>',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            selected: null,
                        }
                    },
                    customize: function (win) {
                        $(win.document.body).css('direction', 'rtl');
                        $(win.document.body).find('th').css('background-color', 'rgb(0, 123, 255)');
                        $(win.document.body).find('th').css('text-align', 'center');
                        $(win.document.body).find('th').css('color', 'white');

                    }
                },


                {
                    extend: 'collection',
                    text:'<i class="fas fa-columns" title="تخصيص الأعمده"></i>',
                    buttons: [
                        {
                            extend: 'colvis',
                            collectionTitle: '',
                            text:'<i class="fas fa-file-signature" title="تخصيص الأعمده"></i>',
                            collectionLayout: 'two-column'
                        }
                    ]
                },
               {
                    extend: 'print',
                    autoPrint: false,
                    title:'',
                    text:' <i class="fas fa-mouse-pointer" title="إطبع المُحدد"></i>',
                    messageTop: '<img src="'+src+'"style="width :100%;">'+'<br><h2>'+title+
                        '</h2>',
                    exportOptions: {
                        columns: ':visible'
                       
                    },
                    customize: function (win) {
                        $(win.document.body).css('direction', 'rtl');
                        $(win.document.body).find('th').css('background-color', 'rgb(0, 123, 255)');
                        $(win.document.body).find('th').css('text-align', 'center');
                        $(win.document.body).find('th').css('color', 'white');

                    }
                }
            ],
            language: {
                "zeroRecords": "لا يوجد بيانات للبحث",
                "emptyTable":  "لا يوجد بيانات",
                "paginate": {
                    "first":      "الأول",
                    "last":       "الأخير",
                    "next":       "التالي",
                    "previous":   "السابق"
                },
                "infoEmpty":      "",
                "info":           "",
                "search":"",
                "searchPlaceholder": "ابحث",
                "searching" :" ",
                "infoFiltered": " ",
                "select":{
                    rows: "تم تحديد %d   صف"
                },
                buttons: {
                    pageLength:
                        {
                            _: '<i class="fas fa-grip-lines" title="تخصيص الصفوف"></i> %d ',
                            '-1':'<i class="fas fa-grip-lines"></i> الكل '
                        }
                }


            }
        });

    });
        $(function () {
        var title = document.title;
        var company ={{company.id}};
        var src ='../files/'+company+'.png';
        var table = $('#example0').DataTable( {
            paging: true,
            lengthChange: true,
            searching: true,
            fixedColumns:   true,
            ordering: false,
            autoWidth: false,
            responsive: true,
            select:true,
            AutoFill:true,
            lengthMenu: [
                [ 10, 25, 50, -1 ],

                ['<i class="fas fa-grip-lines" title="أظهر 10 صفوف"></i> 10 ','<i class="fas fa-grip-lines" title="أظهر25 صف"></i> 25 ','<i class="fas fa-grip-lines" title="أظهر 50 صف"></i> 50 ','<i class="fas fa-grip-lines" title="أظهر كل صفوف"></i> الكل ']


            ],
            colReorder: {
                realtime: true
            },
            dom: 'Bfrtip',
            buttons:[
                {
                    text: '<i class="fas fa-plus-circle" title="إضافة"></i>',
                    title: '',
                    action: function ( e, dt, button, config ) {
                        window.location = 'new';
                    }
                },
                {
                    extend: 'pageLength'

                } ,
                  {
                text: 'إجمالي',
                action: function ( e, dt, node, config ) {
                      alert(table.rows({ 'search': 'applied' }).count());
                }
                 },
                {

                    extend: 'excel',
                    text: '<i class="fas fa-file-excel" title="Excel sheet"></i>',
                    title: '',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            selected: null,
                        }
                    }
                },
                {
                    extend: 'print',
                    autoPrint: false,
                    title:'',
                    text: '<i class="fas fa-print" title="طباعه الكل"></i>',
                    messageTop: '<img src="'+src+'"style="width :100%;">'+'<br><h2>'+title+
                    '</h2>',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                            selected: null,
                        }
                    },
                    customize: function (win) {
                        $(win.document.body).css('direction', 'rtl');
                        $(win.document.body).find('th').css('background-color', 'rgb(0, 123, 255)');
                        $(win.document.body).find('th').css('text-align', 'center');
                        $(win.document.body).find('th').css('color', 'white');

                    }
                },


                {
                    extend: 'collection',
                    text:'<i class="fas fa-columns" title="تخصيص الأعمده"></i>',
                    buttons: [
                        {
                            extend: 'colvis',
                            collectionTitle: '',
                            text:'<i class="fas fa-file-signature" title="تخصيص الأعمده"></i>',
                            collectionLayout: 'two-column'
                        }
                    ]
                },
               {
                    extend: 'print',
                    autoPrint: false,
                    title:'',
                    text:' <i class="fas fa-mouse-pointer" title="إطبع المُحدد"></i>',
                    messageTop: '<img src="'+src+'"style="width :100%;">'+'<br><h2>'+title+
                        '</h2>',
                    exportOptions: {
                        columns: ':visible'
                       
                    },
                    customize: function (win) {
                        $(win.document.body).css('direction', 'rtl');
                        $(win.document.body).find('th').css('background-color', 'rgb(0, 123, 255)');
                        $(win.document.body).find('th').css('text-align', 'center');
                        $(win.document.body).find('th').css('color', 'white');

                    }
                }
            ],
            language: {
                "zeroRecords": "لا يوجد بيانات للبحث",
                "emptyTable":  "لا يوجد بيانات",
                "paginate": {
                    "first":      "الأول",
                    "last":       "الأخير",
                    "next":       "التالي",
                    "previous":   "السابق"
                },
                "infoEmpty":      "",
                "info":           "",
                "search":"",
                "searchPlaceholder": "ابحث",
                "searching" :" ",
                "infoFiltered": " ",
                "select":{
                    rows: "تم تحديد %d   صف"
                },
                buttons: {
                    pageLength:
                        {
                            _: '<i class="fas fa-grip-lines" title="تخصيص الصفوف"></i> %d ',
                            '-1':'<i class="fas fa-grip-lines"></i> الكل '
                        }
                }


            }
        });

    });

</script>
        <!-- Page script -->
<script>


            $(function () {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                //Datemask dd/mm/yyyy
               

                //Date range picker
                $('#reservation').daterangepicker()
                //Date range picker with time picker
                $('#reservationtime').daterangepicker({
                    timePicker: true,
                    timePickerIncrement: 30,
                    locale: {
                        format: 'MM/DD/YYYY hh:mm A'
                    }
                })
                //Date range as a button
                $('#daterange-btn').daterangepicker(
                    {
                        ranges   : {
                            'Today'       : [moment(), moment()],
                            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        startDate: moment().subtract(29, 'days'),
                        endDate  : moment()
                    },
                    function (start, end) {
                        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                    }
                )

                //Timepicker
                $('#timepicker').datetimepicker({
                    format: 'LT'
                })

                //Bootstrap Duallistbox
                $('.duallistbox').bootstrapDualListbox()

                //Colorpicker
                $('.my-colorpicker1').colorpicker()
                //color picker with addon
                $('.my-colorpicker2').colorpicker()

                $('.my-colorpicker2').on('colorpickerChange', function(event) {
                    $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
                });

                $("input[data-bootstrap-switch]").each(function(){
                    $(this).bootstrapSwitch('state', $(this).prop('checked'));
                });

            })
        </script>
<script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();
            });

        </script>
<script>
            function showTime() {
                // to get current time/ date.
                var date = new Date();
                // to get the current hour
                var h = date.getHours();
                // to get the current minutes
                var m = date.getMinutes();
                //to get the current second
                var s = date.getSeconds();
                // AM, PM setting
                var session = "AM";

                //conditions for times behavior
                if (h == 0) {
                    h = 12;
                }
                if (h >= 12) {
                    session = "PM";
                }

                if (h > 12) {
                    h = h - 12;
                }
                m = m < 10 ? (m = "0" + m) : m;
                s = s < 10 ? (s = "0" + s) : s;

                //putting time in one variable
                var time = h + ":" + m + ":" + s + " " + session;
                //putting time in our div
                $("#clock").html(time);
                //to change time in every seconds
                setTimeout(showTime, 1000);
            }
            showTime();
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#imagePreview").css(
                            "background-image",
                            "url(" + e.target.result + ")"
                        );
                        $("#imagePreview").hide();
                        $("#imagePreview").fadeIn(650);

                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $(document).ready(function() {
                $("#click").trigger('click');
            });


        </script>
<script type="text/javascript">
            var foopicker = new FooPicker({
                id: 'datepicker',
                dateFormat: 'yyyy/MM/dd',
                disable: ['']

            });
            var foopicker = new FooPicker({
                id: 'datepicker2',
                dateFormat: 'yyyy/MM/dd',

            });
            var foopicker = new FooPicker({
                id: 'datepicker3',
                dateFormat: 'yyyy-MM-dd',

            });
            var foopicker = new FooPicker({
                id: 'datepicker4',
                dateFormat: 'yyyy-MM-dd',

            });


    </script>
  <script>
// (function () {
//   var $;

//   $ = jQuery;

//   $(document).ready(function () {
//     return $('#fingerprints').on('click', function () {
//       return $(this).toggleClass('button--loading');
//     });
//   });

// }).call(this);


//# sourceURL=coffeescript
</script>
</body>
</html>
