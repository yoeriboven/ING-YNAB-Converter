# ING to YNAB converter

Converts the .csv export from ING into a format You Need A Budget accepts

## Getting Started


### Prerequisites

You will need these to use the converter:

* PHP (7.0 +) (There are plenty of tutorials how to install)
* ING .csv file holding your transactions

### Using the software

Run the command below to convert your file.

* Converter.php is the path to the software
* input.csv is the path to the transactions file downloaded from ING

```
php converter.php input.csv
```

### Customization

**Change Payees**

Most payees are displayed as an ambiguous string which you probably manually change to something more readable. You can do this automatically by filling the `payeesList` property on `Converter`.

```
protected $payeesList = [
	"BOL.COM BV" => "Bol.com",
	"BELASTINGDIENST" => "Belastingdienst",
	"Videoland door Buckaroo" => "Videoland"
]
```

**Change Memos**

Memos can be changed based on certain conditions.

The example below shows how to change the normal memo for *zorgtoeslag* into something more readable.

```
protected function formatMemo($row)
{
	$payee = $this->formatPayee($row[1]);

	$memo = $row[8];

	if ($payee == 'Belastingdienst') {

    	// Does the memo contain 'VOORSCHOT ZORGTOESLAG'?
		if (strpos($memo, 'VOORSCHOT ZORGTOESLAG') !== false) {
			$month = date_format(date_create_from_format('Ymd', $row[0]), 'n');
			return 'Zorgtoeslag '.$this->formatMonth($month);
		}
	}


	return $memo;
}
```


### Other banks?

In case you use a different Dutch bank, [let me know]() and I'll try to support your bank.
