<div class="search-box">
<?php $search_text = ""; ?> 
<form method="get" id="searchform"  
action="<?php echo get_site_url(); ?>/" class="search-form"> 
<label for="s" class="screen-reader-text">Search for:</label>
<div class="searchform-input-wrapper"><input type="text" class="searchform__input" value="<?php echo $search_text; ?>"  
name="s" id="search"  
onblur="if (this.value == '')  
{this.value = '<?php echo $search_text; ?>';}"  
onfocus="if (this.value == '<?php echo $search_text; ?>')  
{this.value = '';}" /></div>
<input type="hidden" id="searchsubmit" /> 
</form>
</div>