			{if $gid eq "14"}
				 <div style="background-color: black; color: white; padding: 10px;">
					<label for="question_dropdown" style="color: white;">Frequently Asked Questions</label></br>
					<select id="question_dropdown" class="form-control text-dark mb-3">
							<option value="promo_about">Select Question.</option>
							<option value="promo_about">What is the TVHub IPTV Box promotion about?</option>
							<option value="box_unique">What makes the TVHub IPTV Box unique?</option>
							<option value="address">Why is it important to ensure my shipping address and phone number are up to date before placing the order?</option>
							<option value="2+boxes">Can I simultaneously use multiple free IPTV boxes if I order a 1-year plan with two or more boxes?</option>
							<option value="box_other_services">Can I use the TVHub IPTV Box with other services?</option>
							<option value="internet_connection">Do I need a specific internet connection for the TVHub IPTV Box?</option>
							<option value="get_free_box">How do I get the free TVHub IPTV Box?</option>
							<option value="warranty_support">Is there a warranty or support for the TVHub IPTV Box?</option>
							<option value="box_shipping">How long does it take for the TVHub IPTV Box to arrive?</option>
							<option value="add_subscription">Can the 1-year subscription be added to my existing plan?</option>
							<option value="recording">Can I record live tv with TVHub Android Box?</option>
							<option value="portable">Can I use the box at different location. For example, my cottage or friends house?</option>
							<option value="vpn">Does the TVHub box support VPN?</option>

						</select>
				</div>
				<div id="answer_container" style="background-color: black; color: white; padding: 10px;">
				<!--	<label for="answer_text">Answer:</label></br> -->
					<span id="answer_placeholder"></span></br>
				</div>
				
				 <script>
        document.getElementById('question_dropdown').addEventListener('change', function() {
            var question = this.value;
            var answer = '';

            // Depending on the selected question, set the corresponding answer
            switch (question) {
                 case '2+boxes':
                    answer = 'Certainly, each box will be equipped with its own dedicated connection, ensuring seamless streaming without any buffering issues.';
                    break;

				case 'promo_about':
                    answer = 'Our promotion offers a free complimentary customized TVHub IPTV Box with 1 Year service subscription. This box comes preconfigured with cutting-edge technology aimed at eliminating buffering issues, providing you with a seamless streaming experience.';
                    break;
                case 'box_unique':
                    answer = 'The TVHub IPTV Box is exclusively customized for our service and features technology not available with any other provider. It\'s designed to ensure smooth streaming without buffering interruptions, offering an unparalleled entertainment experience.';
                    break;
                case 'address':
                    answer = ' It\'s crucial to ensure your shipping address and phone number are up to date before placing the order to ensure smooth delivery of your TVHub IPTV Box. A correct shipping address and phone number help prevent delivery delays and ensure that our shipping partners can reach you if needed. Keeping this information current helps us deliver your order promptly and ensures a seamless experience from purchase to delivery.';
                    break;
					
                case 'box_other_services':
                    answer = 'No, these devices are specifically designed to work with our service. They are preconfigured to seamlessly integrate with our platform, ensuring optimal performance and compatibility.';
                    break;
                case 'internet_connection':
                    answer = 'Yes, for the best experience, we recommend using either an Ethernet connection or a strong 5Ghz WiFi network. This ensures stable and reliable connectivity, minimizing any potential streaming issues.';
                    break;
                case 'get_free_box':
                    answer = 'Simply subscribe to our service, and the complimentary TVHub IPTV Box will be included with your subscription. There are no additional charges for the box; it\'s our gift to you to enhance your entertainment experience.';
                    break;
                case 'warranty_support':
                    answer = 'Yes, the TVHub IPTV Box comes with a 1 year warranty, and our customer support team is available to assist you with any questions or issues you may encounter. We\'re dedicated to ensuring your satisfaction with both our service and the accompanying hardware.';
                    break;
                case 'box_shipping':
                    answer = 'The TVHub IPTV Box typically arrives within 7-10 days from the date of order placement. Please note that this timeframe does not include 1-2 days of processing. We aim to deliver your box promptly to ensure you can start enjoying our service as soon as possible.';
                    break;
                case 'add_subscription':
                    answer = 'Yes, the 1-year subscription can be seamlessly added to your existing plan. Whether you\'re a new subscriber or currently enjoying our services, extending your subscription is hassle-free. Simply select the desired 1 Year + free box plan, and your subscription will be automatically extended, ensuring uninterrupted access to our premium content.';
                    break;
				case 'recording':
                    answer = 'Yes. We highly recommend an external harddrive as the TVHub Android Box only has 16GB of storage.';
                    break;
				case 'portable':
                    answer = 'Yes. The box can be used anywhere on the globe with internet service';
                    break;
				case 'vpn':
                    answer = 'To download VPN, open the App Store. Select VPN, and choose the VPN of your choice. We currently have the popular VPN services: Nord VPN, Surf Shark, Express VPN. Please submit ticket if you would like additional VPN services providers added.';
                    break;

            }

            // Update the answer placeholder with the selected answer
            document.getElementById('answer_placeholder').innerText = answer;
        });
		</script>
	 {/if}

{if $gid neq "14"}
    <div style="background-color: black; color: white; padding: 10px; position: relative; z-index: 10;">
        <label for="question_dropdown" style="color: white;">Frequently Asked Questions</label><br>
        <select id="question_dropdown" class="form-control text-dark mb-3">
            <option value="">Select Question.</option>
            <option value="firestick_setup">How do I set up on Firestick?</option>
            <option value="firestick_apps">Which apps are available for Amazon Firestick?</option>
            <option value="kodi_simple_client">How to watch IPTV on Kodi using IPTV Simple Client?</option>
            <option value="kodi_tvhub_player">How to watch IPTV on Kodi using TVHub IPTV Player?</option>
			<option value="android_apps">How do I setup IPTV service on an Android device?</option>
            <option value="internet_connection">Do I need a specific internet connection for the TVHub IPTV Box?</option>
        </select>
    </div>
    <div id="answer_container" style="background-color: black; color: white; padding: 20px; position: relative; z-index: 2;">
        <span id="answer_placeholder"></span><br>
    </div>
    <div id="iframe_container" style="display: none; padding: 10px; position: relative; z-index: 1;">
        <iframe id="iframe_1" src="" width="100%" height="900px" style="border:none; position:relative; top:-155px;"></iframe>
    </div>

    <script>
        document.getElementById('question_dropdown').addEventListener('change', function() {
            var question = this.value;
            var answer = '';

            // Hide the iframe container initially
            document.getElementById('iframe_container').style.display = 'none';
            document.getElementById('iframe_1').src = ''; // Clear the iframe src
            document.getElementById('answer_placeholder').innerText = ''; // Clear the text answer

            // Depending on the selected question, set the corresponding answer
            switch (question) {
                case 'firestick_setup':
                    document.getElementById('iframe_container').style.display = 'block';
                    document.getElementById('iframe_1').src = 'https://optimedia.tv/knowledgebase/67/How-to-enable-Apps-from-Unknown-Sources-on-an-Amazon-Fire-TV-or-Fire-TV-Stick.html';
                    break;
                case 'firestick_apps':
                    document.getElementById('iframe_container').style.display = 'block';
                    document.getElementById('iframe_1').src = 'https://optimedia.tv/knowledgebase/63/Amazon-Firestick-Apps.html';
                    break;
                case 'kodi_simple_client':
                    document.getElementById('iframe_container').style.display = 'block';
                    document.getElementById('iframe_1').src = 'https://optimedia.tv/knowledgebase/58/IPTV-Simple-Client.html';
                    break;
                case 'kodi_tvhub_player':
                    document.getElementById('iframe_container').style.display = 'block';
                    document.getElementById('iframe_1').src = 'https://optimedia.tv/knowledgebase/73/TVHub-Player.html';
                    break;
                case 'android_apps':
                    document.getElementById('iframe_container').style.display = 'block';
                    document.getElementById('iframe_1').src = 'https://optimedia.tv/knowledgebase/38/APP-DOWNLOAD-LINKS.html';
                    break;

                case 'internet_connection':
                    answer = 'Yes, for the best experience, we recommend using either an Ethernet connection or a strong 5Ghz WiFi network. This ensures stable and reliable connectivity, minimizing any potential streaming issues.';
                    break;
                default:
                    answer = ''; // Clear the answer if no valid option is selected
                    break;
            }

            // Update the answer placeholder with the selected answer
            if (answer !== '') {
                document.getElementById('answer_placeholder').innerText = answer;
            }
        });
    </script>
{/if}
			