# [TreeBundle](https://github.com/symfony-cmf/TreeBundle)

This bundle wraps jsTree jQuery plugin
http://www.jstree.com/ 

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
* Call `$("#tree").jstree({/* parameters */})` - assuming here *#tree* is the selector of your list.
* Provide *url* value pointing to a server-side-something returning lists of children for any given node ID.
Server must reply in JSON format, this is an example:

```
    [
        {"data":"root","attr":{"id":"root","rel":"folder"},"state":"closed","children":
            [
                {"data":"content","attr":{"id":"child1","rel":"folder"},"state":"closed"},
                {"data":"menu","attr":{"id":"child2","rel":"folder"},"state":"closed"},
                {"data":"routes","attr":{"id":"child3","rel":"folder"},"state":"closed"}
            ]
        }
    ]
```

* More info on setup available on [jsTree's website](http://www.jstree.com/documentation).

## Example

    <html>
        <head>
            <title>CMF Sandbox - Treeview test</title>

            <link href="/bundles/symfonycmftree/css/jquery.treeview.css" media="screen" type="text/css" rel="stylesheet" />

            <script src="/bundles/sonatajquery/jquery-1.7.1.js" type="text/javascript"></script>

            <script src="{{ asset('bundles/symfonycmftree/js/jstree/jquery.jstree.js') }}" type="text/javascript"></script>

            <script type="text/javascript">
                function initTrees() {

                    jQuery("#tree").jstree({ 
                        "plugins" :     [ "themes", "types", "ui", "json_data" ],
                        "json_data": {
                            "ajax": {
                                url:    "subtree.php",
                                data:   function (node) {
                                    return { 'root' : jQuery(node).attr('id') };
                                }
                            }
                        },
                        "types": {
                            "max_depth":        -2,
                            "max_children":     -2,
                            "valid_children":  [ "folder" ],
                            "types": {
                                "default": {
                                    "valid_children": "none",
                                    "icon": {
                                        "image": "/images/document.png"
                                    }
                                },
                                "folder": {
                                    "valid_children": [ "default", "folder" ],
                                    "icon": {
                                        "image": "/images/folder.png"
                                    }
                                }
                            }
                        }
                    })
                    .bind("select_node.jstree", function (event, data) {
                        {% set token = '@@ID@@' %}
                        window.location = "edit.php?id=" + data.rslt.obj.attr("id");
                    })
                    .delegate("a", "click", function (event, data) { event.preventDefault(); });
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
