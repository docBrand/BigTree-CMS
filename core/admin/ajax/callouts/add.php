<?
	if ($_POST["groups"]) {
		$items = $admin->getCalloutsInGroups($_POST["groups"]);
	} else {
		$items = $admin->getCallouts("name ASC");
	}

	$type = $items[0]["id"];
	$bigtree["resources"] = array("type" => $type);
	$bigtree["callout_count"] = intval($_POST["count"]);
	$bigtree["callout_key"] = htmlspecialchars($_POST["key"]);
?>
<div id="callout_type">
	<fieldset>
		<label>Callout Type</label>
		<? if (count($items) > 0) { ?>
		<select name="<?=$bigtree["callout_key"]?>[<?=$bigtree["callout_count"]?>][type]">
			<? foreach ($items as $item) { ?>
			<option value="<?=$item["id"]?>"><?=$item["name"]?></option>
			<? } ?>
		</select>
		<? } else { ?>
		<input type="text" disabled="disabled" value="No callouts available" />
		<? } ?>
	</fieldset>
</div>
<div id="callout_resources" class="callout_fields">
	<? include BigTree::path("admin/ajax/callouts/resources.php") ?>
</div>

<script>
	$("#callout_type select").change(function(event,data) {
		// TinyMCE tooltips and menus sometimes get stuck
		$(".mce-tooltip, .mce-menu").remove();

		$("#callout_resources").load("<?=ADMIN_ROOT?>ajax/callouts/resources/", {
			type: data.value,
			count: <?=$bigtree["callout_count"]?>,
			key: "<?=$bigtree["callout_key"]?>"
		},BigTree.formHooks).scrollTop(0);
	});
</script>