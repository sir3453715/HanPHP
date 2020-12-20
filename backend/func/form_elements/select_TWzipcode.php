<script src="js/TWzipcode/jquery.twzipcode.min.js"></script>
<?php
echo '
<div class="form-group row">
<label class="col-sm-2" for="val-username">'.($vv['title']).'</label>
<div class="col-sm-10">
     <div class="row" id="twzipcode">
     	<div class="col-md-6">
     		<div data-role="county"
		         data-name="county"
		         data-value="'. ($vv['value']) .'"
		         data-style="form-control">
		    </div>
        </div>
    	<div class="col-md-6">
			<div data-role="district"
		         data-name="district"
		         data-value="'. ($vv['value1']) .'"
		         data-style="form-control">
		    </div>
        </div>
        <div data-role="zipcode" class="hide"></div>
	</div>
</div>
</div>
';
?>
<script>
$('#twzipcode').twzipcode({
              'hideCounty': ['金門縣','連江縣','澎湖縣'],
              //'css': ['col-md-6', 'col-md-6', 'hide'],
            'countyName': 'county', // 預設值為 county
                    'districtName': 'district', // 預設值為 district
                    //'zipcodeName': 'zipcode', // 預設值為 zipcode
                    'zipcodeIntoDistrict':true,
                    'readonly': true
            });
</script>
