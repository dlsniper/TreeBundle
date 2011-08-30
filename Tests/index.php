<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
        <title>PHPCR navigator</title>

        <link rel="stylesheet" href="../assets/css/jquery.treeview.css" />

        <script src="../assets/js/jquery.js" type="text/javascript"></script>
        <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
        <script src="../assets/js/jquery.treeview.js" type="text/javascript"></script>
        <script src="../assets/js/jquery.treeview.edit.js" type="text/javascript"></script>
        <script src="../assets/js/jquery.treeview.async.js" type="text/javascript"></script>

        <script type="text/javascript">
            function initTrees() {
                $("#test_tree").treeview({
                    url: "test_source.php"
                })
            }
            $(document).ready(function(){
                initTrees();

            });
        </script>


    </head>
    <body>

        <ul id="test_tree">
        </ul>

    </body>
</html>