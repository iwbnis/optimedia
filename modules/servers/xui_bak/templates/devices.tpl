	<h3>{$translate_other_devices}</h3>
	{$translate_stream_output}
	<div class="radio">
	  <label><input type="radio" name="stream_output" checked="checked" value="ts">MPEGTS</label>
	</div>
	<div class="radio">
	  <label><input type="radio" name="stream_output" value="m3u8">HLS</label>
	</div>
	<div class="radio">
	  <label><input type="radio" name="stream_output" value="rtmp">RTMP</label>
	</div>
	<script>
	$(document).ready(function() {
		var myRadio = $('input[name=stream_output]');
		var mode=myRadio.filter(':checked').val();
		 $('.dropdown-menu.mydropdown a').each(function(){
			  $(this).attr('href', $(this).data('url') + mode)
			})
		myRadio.on('change', function () {
			var mode=myRadio.filter(':checked').val();
			//here change the urls
			$('.dropdown-menu.mydropdown a').each(function(){
			  $(this).attr('href', $(this).data('url') + mode)
			})
		});            
	});
	</script>
	{$translate_dropdown_name}
	<div class="dropdown">
	  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{$translate_dropdown_action}
	  <span class="caret"></span></button>
	  <ul class="dropdown-menu mydropdown">
		<li>
			<a target="_blank"
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/m3u?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/m3u?output=">M3U
			</a>
		</li>
		<li>
			<a target="_blank"
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/m3u_plus?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/m3u_plus?output=">M3U Plus
			</a>
		</li>
		<li>
			<a target="_blank"
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/enigma16?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/enigma16?output=">Enigma2 OE 1.6
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/dreambox?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/dreambox?output=">Enigma2 OE 2.0
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/gigablue?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/gigablue?output=">Gigablue
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/simple?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/simple?output=">Simple List
			</a>
		</li>
		<li>
			<a target="_blank"
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/octagon?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/octagon?output=">Octagon
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/starlivev3?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/starlivev3?output=">Starlive v3/Starsat
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/mediastar?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/mediastar?output=">Mediastar/Geant/Tiger
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/starlivev5?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/starlivev5?output=">Starlive v5
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/webtvlist?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/webtvlist?output=">WebTV List
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/ariva?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/ariva?output=">Ariva
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/fps?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/fps?output=">Fortec999/Prifix9400/Starport
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/spark?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/spark?output=">Spark
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/revosun?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/revosun?output=">Revolution6060/Sunplus
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/gst?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/gst?output=">Tiger/Qmax/Hyper/Royal
			</a>
		</li>
		<li>
			<a target="_blank" 
				data-url="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/zorro?output="
				href="{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/zorro?output=">Zorro
			</a>
		</li>
	  </ul>
	</div>


	<hr>
	<h3>{$translate_autoscripts}</h3>
	<b>Enigma 2 OE 1.6 Auto Script</b>
	<div class="form-group">
	  <label for="usr"></label>
	  <input type="text" class="form-control" id="e2oe16" value="wget -O /etc/enigma2/iptv.sh '{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/enigma216_script?output=hls' && chmod 777 /etc/enigma2/iptv.sh && /etc/enigma2/iptv.sh">
	</div>
	<b>Enigma 2 OE 2.0 Auto Script</b>
	<div class="form-group">
	  <label for="usr"></label>
	  <input type="text" class="form-control" id="e2oe16" value="wget -O /etc/enigma2/iptv.sh '{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/enigma22_script?output=hls' && chmod 777 /etc/enigma2/iptv.sh && /etc/enigma2/iptv.sh">
	</div>
	<b>Octagon Auto Script</b>
	<div class="form-group">
	  <label for="usr"></label>
	  <input type="text" class="form-control" id="e2oe16" value="wget -qO /var/bin/iptv '{$protocol}{$moduleParams['serverhostname']}:{$moduleParams['serverport']}/playlist/{$extraVariable1}/{$password}/octagon_script?output=hls'">
	</div>
	<hr-->


	<!--div class="row">dd
		<div class="col-sm-4">
			<form method="post" action="clientarea.php?action=productdetails">
				<input type="hidden" name="id" value="{$serviceid}" />
				<input type="hidden" name="customAction" value="overview" />
				<button type="submit" class="btn btn-default btn-block">
					<i class="fa fa-arrow-circle-left"></i>
					Back to Overview
				</button>
			</form>
		</div>
	</div--!>

