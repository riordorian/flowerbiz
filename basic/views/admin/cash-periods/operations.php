<table class="table table-striped m-t">
	<thead>
	<tr>
		<th>Операция</th>
		<th>Сумма</th>
		<th>Ответственный за операцию</th>
	</tr>
	</thead>
	
	<tbody><?
		foreach($arMoneyMovements as $arMoneyMovement){
			?><tr>
				<td><?=$arMoneyMovement['NAME']?></td>
				<td><?=$arMoneyMovement['AMOUNT']?> руб.</td>
				<td><?=$arUsers[$arMoneyMovement['USER_ID']]?></td>
				<td><?=$arMoneyMovement['COMMENT']?></td>
			</tr><?
		}
	?></tbody>
</table>