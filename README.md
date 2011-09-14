# [TreeBundle](https://github.com/symfony-cmf/TreeBundle)

This bundle wraps Jörn Zaefferer's Treeview jQuery plugin
http://github.com/jzaefferer/jquery-treeview

## Dependencies

This bundle depends on jQuery.
http://jquery.com/

## Setup

* Install jQuery. [SonatajQueryBundle](https://github.com/sonata-project/SonatajQueryBundle) strongly suggested.
* Include CSS & JS files in your template
* Call `$("#tree").treeview()` - assuming here *#tree* is the selector of your list
* Provide *url* value pointing to a server-side-something returning lists of children for any given node ID.
Server must reply in JSON format, this is an example:

```
    [
        {"text":"anonimarmonisti","id":"\/com\/anonimarmonisti","hasChildren":true},
        {"text":"romereview","id":"\/com\/romereview","hasChildren":false},
        {"text":"5etto","id":"\/com\/5etto","hasChildren":true},
        {"text":"wordpress","id":"\/com\/wordpress","hasChildren":true}
    ]
```

* More info on setup available on Treeview's [GitHub](http://github.com/jzaefferer/jquery-treeview)

## Example

    <html>
        <head>
            <title>CMF Sandbox - Treeview test</title>

            <link href="/bundles/ideatotree/css/jquery.treeview.css" media="screen" type="text/css" rel="stylesheet" />

            <script src="/bundles/sonatajquery/jquery-1.4.4.js" type="text/javascript"></script>

            <script src="/bundles/ideatotree/js/jquery.cookie.js" type="text/javascript"></script>
            <script src="/bundles/ideatotree/js/jquery.treeview.js" type="text/javascript"></script>
            <script src="/bundles/ideatotree/js/jquery.treeview.edit.js" type="text/javascript"></script>
            <script src="/bundles/ideatotree/js/jquery.treeview.async.js" type="text/javascript"></script>

            <script type="text/javascript">
                function initTrees() {
                    $("#tree").treeview({
                        url:    "/children.php",
                        toggle: function() {
                            $.ajax({
                                url: "properties.php",
                                dataType: "json",
                                data: {
                                    root: this.id
                                },
                                success: function(response) {
                                    $("#properties").empty()
                                    $.each(response, function (index, property) {
                                        $("#properties").append(
                                            '<tr><td>' + this.name + '</td><td>' + this.value + '</td></tr>'
                                        );
                                    });
                                }
                            });
                        }
                    })
                }
                $(document).ready(function(){
                    initTrees();

                });
            </script>

        </head>
        <body>

            <ul id="tree">
            </ul>

            <table border="1" id="properties"></table>

            <hr/>

            {% block content %}
                Hello {{ name }}!
            {% endblock %}
        </body>
    </html>