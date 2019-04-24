# Dutch YNAB converter

Converts the .csv export from a Dutch bank into a format You Need A Budget accepts

## Getting Started


### Prerequisites

You will need these to use the converter:

* PHP (7.0 +) (There are plenty of tutorials how to install)
* .csv file holding your transactions

### Using the software

Run the command below to convert your file.

* converter.php is the path to the software
* input.csv is the path to the transactions file downloaded from ING
* ing is the name of your bank

```
php converter.php input.csv ing
```

### Supported banks
* ING Bank
* Rabobank


### Other banks?

In case you use a different Dutch bank, [let me know](https://twitter.com/yoeriboven) and I'll try to support your bank.
