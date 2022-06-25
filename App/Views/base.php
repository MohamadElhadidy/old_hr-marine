<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../images/favicon.png">

    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" type="text/css"
        href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css">

    <link rel="stylesheet" type="text/css"
        href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    {% block style %}{% endblock %}
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
    @import url("//fonts.googleapis.com/css2?family=Changa:wght@600&display=swap");

    html,
    body {
        font-family: "Changa", sans-serif !important;
    }

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
    </style>
</head>

<body>
    {% for message in flash_messages %}
    <div id="pageMessages">

    </div>
    <div class="container">
        <input class="cli" type="hidden"
            onclick="createAlert('',{{message.body}},'',{{message.type}},true,true,'pageMessages');" value="click">
    </div>
    {% endfor %}

    {% block body %}
    {% endblock %}
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
    {% block footer %}
    {% endblock %}
    <script>
    $(document).ready(function() {
        $(".cli").trigger('click');
    });
    </script>
</body>

</html>