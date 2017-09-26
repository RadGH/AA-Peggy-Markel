<form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
<span class="fa fa-search"></span>
	<input type="text" class="search_input" value="SEARCH + PRESS ENTER" name="s" id="s" onfocus="if (this.value == 'SEARCH + PRESS ENTER') {this.value = '';}" onblur="if (this.value == '') {this.value = 'SEARCH + PRESS ENTER';}" />
	<input type="hidden" id="searchsubmit" value="Search" />
</form>
