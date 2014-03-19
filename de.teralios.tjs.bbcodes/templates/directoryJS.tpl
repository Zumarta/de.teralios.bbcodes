{if $teraDirectory|isset && $teraDirectory->hasJumpMarks()}
	<script>
		//<![CDATA[
		$(function(){
			// clean array
			var jumpMark = [
				{
					title: '',
					link: '',
					[
						{title: '', link: ''}
					]
				}       
				];
		});
		//]]>
	</script>
{/if}