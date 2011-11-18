# [TreeBundle](https://github.com/symfony-cmf/TreeBundle)

This bundle wraps Jörn Zaefferer's Treeview jQuery plugin
http://github.com/jzaefferer/jquery-treeview

## Features

* Nodes expanding/collapsing.
* Subtrees lazy loading via JSON replies to AJAX calls.
* Callback function when a node is toggled.

## Setup

### Dependencies

This bundle depends on jQuery.
http://jquery.com/

### How-to

* Install jQuery. [SonatajQueryBundle](https://github.com/sonata-project/SonatajQueryBundle) strongly suggested.
* Add these lines in file deps:

```
[TreeBundle]
    git=git://github.com/symfony-cmf/TreeBundle.git
    target=/bundles/Symfony/Cmf/Bundle/TreeBundle
```

* Add this line in file app/AppKernel.php:

```
public function registerBundles()
{
    $bundles = array(
        // ...
        new Symfony\Cmf\Bundle\TreeBundle\SymfonyCmfTreeBundle(),
    );
    // ...
```

* Launch `php bin/vendors install`
* Include CSS & JS files in your template.
* Call `$("#tree").treeview()` - assuming here *#tree* is the selector of your list.
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

* The optional *toggle* parameter is an hook to perform any further needed action when a node is clicked.
* More info on setup available on Treeview's [GitHub](http://github.com/jzaefferer/jquery-treeview).

## Example

    <html>
        <head>
            <title>CMF Sandbox - Treeview test</title>

            <link href="/bundles/symfonycmftree/css/jquery.treeview.css" media="screen" type="text/css" rel="stylesheet" />

            <script src="/bundles/sonatajquery/jquery-1.4.4.js" type="text/javascript"></script>

            <script src="/bundles/symfonycmftree/js/jquery.cookie.js" type="text/javascript"></script>
            <script src="/bundles/symfonycmftree/js/jquery.treeview.js" type="text/javascript"></script>
            <script src="/bundles/symfonycmftree/js/jquery.treeview.edit.js" type="text/javascript"></script>
            <script src="/bundles/symfonycmftree/js/jquery.treeview.async.js" type="text/javascript"></script>

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