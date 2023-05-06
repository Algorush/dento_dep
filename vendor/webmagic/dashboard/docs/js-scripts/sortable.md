This functionality provides a possibility to sort items in table by using Drag&Drop functionality.

### Activation sorting functionality
You have two ways to activate sortable:

1. When there is an element that will be dragged, then add the class to the parent element **```'js-sortable'```**.
2. When there is no element, then dragging will be carried out directly on the whole element with class **```'js-sortable'```**.

### How to use

* To the parent element, we add the route in the attributes **```'data-url'```** and **```'data-method'```** (_POST/GET_, default _'POST'_), if you do not put a route, then it will refer to the current page.
* Add the class to the element to be dragged **```'js_item_{id}'```** and attribute **```'id'```**.
* To the element on which we initialize the drag, add a class **```'js-sortable-handler'```**.

##### An example of sending to the server:

```http request
   'entity_id': 1
   'reference_entity_id': 2
   'reference_type': 'after'
```
, where:

* '**entity_id**' - id of the element to be dragged;
* '**reference_entity_id**' - id of the element after which you want to place the dragged element;
* '**reference_type**' - specify that the dragged element should be inserted after _'reference_entity_id'_.

##### Example:
```html
<table class="table table-hover table-striped" data-url="/sortable" data-method="POST">
    <tbody class="js-sortable">
        <tr id="1" class="js_item_1">
            <td class="js-sortable-handler">handler 1</td>
            <td>element 2</td>
            ...
        </tr>
        <tr id="2" class="js_item_2">
            <td class="js-sortable-handler">handler 2</td>
            <td>element 2</td>
            ...
        </tr>
    </tbody>
</table>
```