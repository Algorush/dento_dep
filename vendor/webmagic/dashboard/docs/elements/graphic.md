> Graphic

The functional is implemented using the ***\Webmagic\Dashboard\Elements\Graphics\Graphic*** class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/charts/chartjs.html)

The class is used by the html <canvas> element to draw graphics on the fly using JavaScript by setting the desired
coordinates.

- **title** - add a title before the graphic. By default,
- **addGraphicUniqClass** - adds graphics (canvas) class
- **graphicChangeViewUniqClass** - sets the Change of view button of the chart style to a class
- **graphicFormClass** - specifies a class-link to a graph filter
- **dataUrl** - sets the link to the page for receiving data for plotting
- **isChangeViewAvailable** - can you change the view of the chart on the page? (default true)
- **type** - sets the initial view of displaying charts in the default line (2 types are available: bar, line)
- **isLegendDisplay** - display legend? (default true)
- **legendPosition** - location of the legend (default: bottom. Available: bottom, top
- **pointRadius** - size of points on the chart (default: 0)
- **lineTension** - bending smoothness (default: 0)
- **showXAxes** - displaying the background grid along the X axis (default true)
- **showYAxes** - displaying the background grid along the Y axis (default true)
- **labels** - sets labels under X axis
- **addDataSet** - sets named dataset with coords for each labels on X axis. Optional you can set color of dataset and
  background (or it will be random colors).
- **dataUrl** - if you set it param Graphic **discard** labels and addDataSet. On init Graphic it will make ajax request
  to set url in dataUrl param and build graphic on response data.
- **fillWithDummyData** - method fill graphic with preset values.

### How to use

```php
$graphic = (new Graphic())
    ->title('Graphic')
    ->graphicUniqClass('myGraphicUniqClass')
    ->graphicChangeViewUniqClass('myFirstClassOfChangeViewButton')
    ->graphicFormClass('myformClass')
    ->isChangeViewAvailable(true)
    ->type('line')
    ->isLegendDisplay(true)
    ->legendPosition('bottom')
    ->pointRadius(10)
    ->lineTension(0.3)
    ->showXAxes(true)
    ->showYAxes(true)
;
```

#### Method 1: Graphic with data set

```php
$graphic->labels(["January", "February", "March", "April", "May"])
        ->addDataSet('label1', [28, 32, 15, 68, 90], '#f56954', '#f56954')
        ->addDataSet('label2', [90, 5, 80, 50, 95]);
```

#### Method 2: Graphic with data by url

```php
$graphic->dataUrl('http://localhost:8080/dashboard/tech/play/response');
```

After request to `http://localhost:8080/dashboard/tech/play/response` you get so response:

```json
{
  "labels": [
    "January",
    "February",
    "March",
    "April",
    "May"
  ],
  "datasets": [
    {
      "label": "label-item1 ",
      "data": [
        28,
        48,
        40,
        27,
        40
      ]
    },
    {
      "backgroundColor": "#f56954",
      "borderColor": "#f56954",
      "label": "label-item2",
      "data": [
        28,
        100,
        15,
        68,
        90
      ]
    }
  ]
}
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::graphic`

