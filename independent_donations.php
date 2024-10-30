<div id="ft_sunlight_container">
    <div id="ft_sunlight_top">Independent Donations</div>
    <div id="ft_sunlight_dump"></div>
</div>

<script type="text/javascript">
jQuery(document).ready(function()
{
	jQuery.get("http://realtime.influenceexplorer.com/api/outside-spenders/", {apikey: "<?php echo $apikey; ?>", format:"json", page:"1", page_size:"20"}, function(ret)
	{
		var final = "";
		jQuery.each(ret.results, function(index)
		{
			var pos = ret.results[index];
			var spent = pos.total_indy_expenditures.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			var name = pos.name;
			var party, space;
			switch(pos.political_orientation)
			{
				case "R":
					party = "republican";
					break;
				case "D":
					party = "democrat";
					break;
				case "B":
					party = "both";
					break;
				case "I":
					party = "idependent";
					break;
				default:
					party = "na";
			}
			if(name.indexOf(" ")>0)
			{
				name = name.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
			}
			final += "<div class='box_spend'><div class='box_spend_row'><div class='spend_party'><img src='<?php echo plugin_dir_url( __FILE__ )."images/"; ?>"+party+".png' width='50px' height='50px' /></div><div class='spend_info'>";
			final += "<a href='http://realtime.influenceexplorer.com" + pos.committee_url + "' target='_blank'>" + name + "</a><br />";
			final += "$"+spent+"</div></div></div><hr class='clear' />";
		});
		jQuery('#ft_sunlight_dump').html(final);
	});
});
</script>