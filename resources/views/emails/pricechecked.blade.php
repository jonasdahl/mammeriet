<b>Hej å hå!</b><br />
<br />Vi har checkat runt lite på diverse coola möbelaffärer och kommit fram till att priset på "{{ $pricecheck->productInfo->name }}" är typ {{ $pricecheck->unitprice }} kronor!<br />
@if (strlen($pricecheck->unit))
	<br />Den som kollade har också uppgivit lite information om förpackningen:<br>
	"{{ $pricecheck->unit }}".<br />
@endif
<br />
Alltså:<br/>
<br />
<table>
	<tr>
		<td><b>Produkt:</b></td>
		<td>{{ $pricecheck->productInfo->name }}</td>
	</tr>
	<tr>
		<td><b>Produktbeskrivning:</b></td>
		<td>{{ $pricecheck->productInfo->description }}</td>
	</tr>
	<tr>
		<td><b>Pris:</b></td>
		<td>{{ $pricecheck->unitprice }} kr</td>
	</tr>
	<tr>
		<td><b>Förpackningsinformation:</b></td>
		<td>{{ $pricecheck->unit }}</td>
	</tr>
</table>

<br />
Om det inte står något annat är alla priser inklusive moms!<br />

<br />
Solskenshälsningar<br />
Mammeriet<br />