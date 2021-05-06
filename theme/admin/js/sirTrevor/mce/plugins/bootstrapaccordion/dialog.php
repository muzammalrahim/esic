<?php   $hel   =  "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $hell2 =  str_replace("theme/admin/js/sirTrevor/mce/plugins/bootstrapaccordion/dialog.php","",$hel);
?>

<html>
<head>
    <style>
        #accordion-open{
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
        }
        #accordion-title{
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;"
        }
        button{
            background-color: #3c8dbc;
            border-color: #367fa9;
            color: #fff;;
            border-radius: 3px;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid transparent;
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
        }
    </style>
    <script src='<?=  $hell2 ;?>theme\admin\js\sirTrevor\mce\tinymce.min.js'></script>
    <script  src='<?=  $hell2 ;?>assets\tinymce\js\tinymce\plugins\jbimages\plugin.min.js'></script>
    <script>
        tinymce.init({
            selector: "textarea#accordion-content",
            plugins: "spellchecker textcolor colorpicker table jbimages media code ",
            menubar: false,
            height:"50%",
            toolbar: "undo redo | styleselect | fontsizeselect | forecolor | backcolor | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | table| jbimages | media | code ",
            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 24px 24px 28px 30px 36px 40px",
            statusbar: false
        });
    </script>
</head>
<body>
    <h3>Question:</h3>
        <input id="accordion-title" class="form-control"/ >
    <h3>Answer:</h3>
        <textarea id="accordion-content"></textarea>
    <h3>Open at first?</h3>
    <p>
        <select id="accordion-open">
            <option>No</option>
            <option>Yes</option>
        </select>
    </p>
</body>
</html>
