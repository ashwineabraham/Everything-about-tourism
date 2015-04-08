<head>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0
        }

        body{
            margin: 0;
            padding: 0
        }

        @font-face {
            font-family: 'titilliumregular';
            src: url('titillium-regular.eot');
            src: url('titillium-regular.eot?#iefix') format('embedded-opentype'),
                 url('titillium-regular.woff') format('woff'),
                 url('titillium-regular.ttf') format('truetype'),
                 url('titillium-regular.svg#titilliumregular') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        @font-face {
            font-family: 'titillium_bdbold';
            src: url('titillium-bold.eot');
            src: url('titillium-bold.eot?#iefix') format('embedded-opentype'),
                 url('titillium-bold.woff') format('woff'),
                 url('titillium-bold.ttf') format('truetype'),
                 url('titillium-bold.svg#titillium_bdbold') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        h1{
            font-family: titilliumregular;
            font-weight: Lighter;
            color: yellow;
            margin: 0;
            padding: 15;
            text-shadow: 3px 3px 2px rgba(150, 150, 150, 0.7);
            font-size: 52px;
        }

        body{
            margin: 0;
            padding: 0
        }
		select {
			width:267px;
		}

        * {
            font-family: helvetica;
        }
    </style>
</head>

<?php

	include ("dbconnect.php");

// get the URL requested by the client
    $actual_link = $_SERVER["HTTP_HOST"];

// deconstruct the URL using the "." as a delimter
    $link_array=explode('.',$actual_link);

// if the first array value is "www"..
    if ($link_array[0]==='www'){

// then use the second array value to test with
        $site_name=$link_array[1];
    }else{

// otherwise the www is missing and the first array value holds the site name
        $site_name=$link_array[0];
    }

// grab the site details from the SITE_DETAILS table based on the URL
    $query="select * from site_details where site_name='".$site_name."';";
    $result=mysql_query($query);
    while ($row = mysql_fetch_array($result)) {
        
// set a bunch of variables we'll use to define the colour, title, and base SITEKEY
        $site_key=$row["site_key"];
        $site_colour=$row["site_colour"];
        $site_title=$row["site_title"];

    }

	switch ($site_key){
		case "finance":
			$colour="#822a25";
			break;
		case "tourism":
			$colour="#005186";
			break;
		default:
			$colour="#005186";
			break;
	}

?>
	
<body>

	<table width="100%" height="100%" cellspacing="0">
        <tr>
            
                <td colspan="3" height="164" background="images/<?php echo $site_colour; ?>_top_small.gif" valign="middle"><center>
                
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                    <tr>
                        <td valign="middle"><h1><?php echo $site_title; ?></h1></td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff"><img src="images/trans.gif" width="2" height="2"></td>
                    </tr>
                </table></center>

            </td>
        </tr>
  		<tr>

<!-- left column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200" height="1"></td>

<!-- content column -->

			<td valign="top">
				<table>
					<tr>
						<td><font face="arial"><b>TERMS AND CONDITIONS</b><p>

                            <table>
                                <tr>
                                    <td colspan="3">
                                        <font face="arial"><b>Below are the terms and conditions that govern use of the sites listed on the World Specialized Search Engines web sites by which you entered these or associated web sites...referred to herein as "the sites" and/or "these sites"</b><p>
                                        <b>By using any of the Sites, you agree to be bound by these Terms and Conditions of Use (the "TCU") and our Privacy Policy (see below) and other usage guidelines and rules that may be displayed from time to time, all of which are incorporated herein by reference, and to follow the TCU and all applicable laws and regulations governing the sites.</b><p>
                                        <b>If you do not agree, please do not enter or use the sites.</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <font face="arial"><b>The sites are not intended for use by persons under the age of thirteen. Individuals who are under thirteen are expressly prohibited from posting any personally identifiable information about themselves.</b></td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <font face="arial"><b>Data and information relating to securities or otherwise is provided for informational purposes only and is not intended as advice or a recommendation for trading purposes.</b></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><font face="arial"><b>Please direct any questions you may have about the TCU, or any other legal matters, to the following e-mail address: <a href="mailto:manager@worldspecializedsearchengines.com">manager@worldspecializedsearchengines.com</b></td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>1)</b></td>
                                    <td colspan="2"><b>The Everything About Everything and associated web sites' PROPRIETARY RIGHTS AND PERMITTED USE</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">The sites, including without limitation any content, software and services offered thereon, are the property of World Specialized Search Engines and/or its suppliers. It is protected by the copyright and/or other intellectual property laws of Australia and internationally. You are hereby authorized solely to view and to retain a copy of pages of these sites for your own personal use. Do not duplicate, publish, modify, or otherwise distribute the material on these sites unless specifically authorized in writing by World Specialized Search Engines to do so. Legal notices and various other acknowledgements and credits are posted on pages of the sites. Do not remove these legal notices or other acknowledgements or credits, or any related information, contained on pages of the sites.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">You hereby acknowledge and agree that, between World Specialized Search Engines and yourself, all right, title, and interest in and to the sites and the provision thereof, including without limitation any patent rights, patents, programming, business methods, copyrights, trademarks, trade secrets, inventions, know-how, and all other intellectual property rights pertaining thereto, shall be owned exclusively by World Specialized Search Engines.</td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>2)</b></td>
                                    <td colspan="2"><b>PRIVACY POLICY</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">World Specialized Search Engines understands and respects your concerns about privacy and the privacy of all of our users is important. At the same time, we do ask that you provide information about yourself in order for us to understand your needs better and make your experience at World Specialized Search Engines more valuable to you. By submitting the application form you agree with our Privacy Policy as outlined.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">We created this Privacy Policy to provide you with notice of what information World Specialized Search Engines may collect, how such information may be used or shared with third parties, and how such information relates to the operation of the sites. This Privacy Policy is subject to the Terms and Conditions of Use (the "TCU") posted on the sites, including the provisions regarding change or modification of this Privacy Policy and other policies as set forth in the TCU. You are responsible for checking this page periodically for changes and updates to the Privacy Policy. Your use of the site following any posted changes to the Privacy Policy will be deemed an acceptance of such changes. This Privacy Policy is part of, and incorporated into, the TCU. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">By providing any personal information to these sites, you fully understand and unambiguously consent to the collection and processing of such information in Australia, the United States and/or any other country. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">This Privacy Policy explains the following:-</td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>3)</b></td>
                                    <td colspan="2"><b>WHAT PERSONALLY IDENTIFIABLE INFORMATION WORLD SPECIALIZED SEARCH ENGINES COLLECTS FROM YOU AND HOW IT USES THE INFORMATION</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">World Specialized Search Engines collects and stores personal information in several ways at different parts of our sites. This information may include your legal name, email address, age, gender, address, telephone number(s), areas of interest, financial information, User ID, User Password and other self-identifying information. We collect this information in order to provide you with our services more easily, and in a more personalized manner. We may make message boards and discussion forums available to you. If you choose to voluntarily disclose certain information on any such public area of the sites, this Privacy Policy will not cover such disclosure of information. We urge exercising caution when disclosing information on public message boards or discussion forums. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">World Specialized Search Engines also may request certain information using online order or listing forms for products and services. On the order forms, we may collect contact information, financial information, demographic information, method of payment and, if applicable, a credit or debit card number. We may also collect information about you in surveys or for sweepstakes and contests on the sites and information about the searches you perform and the pages you visit on the sites. World Specialized Search Engines may also monitor, on an anonymous aggregate basis, patterns of use in connection with emails that it sends out, including which links are clicked on in our email communications, so that we may use such information to better personalize the content of the sites and our mailings for our users. All such information will be protected in accordance with our Privacy Policy. We may also automatically collect your Internet Protocol address to help diagnose problems and for system administration. World Specialized Search Engines reserves the right to request any additional information necessary to establish and maintain your account for use of the sites. World Specialized Search Engines uses the information collected from you in accordance with this Privacy Policy. Information we collect is used to customize your experience at our sites. We also show you content that we think will be interesting to you, and display content according to the preferences you indicate while on our sites. World Specialized Search Engines may use your information to send you promotional materials about World Specialized Search Engines and its partners. We may also use your information to contact you, if necessary. </td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>4)</b></td>
                                    <td colspan="2"><b>WITH WHOM YOUR INFORMATION MAY BE SHARED</b></td>
                                </tr>
                                <tr>
                                    <td>
                                    <td colspan="2">World Specialized Search Engines will not sell, rent or barter your personal information other than to its business partners as set forth herein. However, we may from time to time aggregate statistical information regarding our customers, traffic patterns and site usage, or sell our research, which may contain aggregate information. In addition, we may report aggregate information to our advertisers. Such aggregate information will not individually identify any user. In order to provide you with co-branded services, and to improve our features, we will sometimes share your information with our partners. 
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">We reserve the right to disclose any information if such action is necessary </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>(a)</b></td>
                                    <td>to conform to the requirements of the law or to comply with legal process or subpoena served on World Specialized Search Engines;</td>   
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>(b)</b></td>
                                    <td>to protect and defend the legal rights or property of World Specialized Search Engines, the sites, or its users, or</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>(c)</b></td>
                                    <td>in an emergency, to protect the health and safety of its users or the general public. We further reserve the right to release any information concerning any user if that user participates (or is reasonably suspected of participating) in any illegal activity, even without a subpoena, warrant, or other court order. We cooperate with law enforcement agencies in identifying those who may be using our servers or services for illegal activities. We also reserve the right to report any suspected illegal activity to law enforcement for investigation or prosecution. </td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>5)</b></td>
                                    <td colspan="2"><b>WHAT CHOICES YOU HAVE REGARDING THE COLLECTION, USE AND DISTRIBUTION OF YOUR INFORMATION</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">You may occasionally receive information about the products or services you have selected to place on your personal World Specialized Search Engines' pages, which may include World Specialized Search Engines' products and services, and the products and services of our partners. World Specialized Search Engines believes that these updates are interesting and informative. If you submit the registration or application form, you thereby consent to being placed on our mailing list. You may subsequently contact us to request to be removed from this list at any time. In every update that we send, we will include an option to discontinue receipt of future updates. World Specialized Search Engines reserves the right to limit any registrations or data on our sites for whatever reason, and to those who will accept our information and to those who will provide the requested information. </td>
                                </tr>
                                <tr>
                                    <td><b>6)</b></td>
                                    <td colspan="2"><b>WHAT TRACKING DEVICES ARE, AND HOW WORLD SPECIALIZED SEARCH ENGINES USES THEM</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">As part of offering and providing customizable and personalized services, World Specialized Search Engines may sometimes use tracking devices to store and sometimes track information about you. A tracking device, (or sometimes called cookie/s) is a small amount of data that is transferred to your computer's hard drive. All portions of the sites that prompt you to log in or that are customizable require that you accept tracking devices. No other company has access to the tracking devices placed on your computer by World Specialized Search Engines unless you select the option to share user-information with World Specialized Search Engines' partners or other web sites incubated or funded by World Specialized Search Engines or its affiliates. We may use tracking device technology to reduce the time required for you to submit your requests and for World Specialized Search Engines to respond to such requests. Tracking devices will not be used by us to retrieve any information about you, or from your computer, that you have not voluntarily given to us. Tracking devices may also be placed on your computer when you link from the sites to our partners' web sites or when you click links provided on our Site. Tracking devices placed on your computer by third parties by or through the sites, if any, are not the responsibility of World Specialized Search Engines and are not subject to the TCU. Please contact the third party placing these tracking devices to find out what information is collected and how it is used. You can usually edit your browser not to accept tracking devices, but the features of our sites may not function properly if you do not accept tracking devices. </td>
                                </tr>
                                <tr>
                                    <td><b>7)</b></td>
                                    <td colspan="2"><b>HOW WORLD SPECIALIZED SEARCH ENGINES PROTECTS YOUR PERSONAL INFORMATION</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">For all our transactions, we employ reasonable and current Internet security methods and technologies. Where appropriate, we password protect, use encryption techniques and install firewalls. We strive to protect you. We encourage our participating service providers to adopt and honor their own consumer privacy policies. For all our efforts to safeguard your privacy, no system can be guaranteed. We cannot ensure or warrant the security of any information that you transmit to us, or that we transmit to you, or guarantee that it will be free from unauthorized access by third parties. Once we receive your information, we use reasonable efforts to ensure its security on our systems. </td>
                                </tr>
                                <tr>
                                    <td><b>8)</b></td>
                                    <td colspan="2"><b>WHAT ELSE YOU SHOULD KNOW ABOUT YOUR ONLINE PRIVACY</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">The sites may also contain links to other web sites and associated advertising on their sites. The privacy policies of those web sites and advertisers may significantly differ from that of our sites. It is your responsibility to contact such web site operator or advertiser directly to determine their privacy policy.</td>
                                </tr>
                                <tr>
                                    <td><b>9)</b></td>
                                    <td colspan="2"><b>HOW TO CONTACT US</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">Any questions about our Privacy Policy, the practices of the sites, or your dealings with the sites should be directed to: Customer Service, World Specialized Search Engines Email: manager@worldspecializedsearchengines.com or write to World Specialized Search Engines, 82 Boundary St Brisbane Qld 4000.</td>
                                </tr>
                                <tr>
                                    <td><b>10)</b></td>
                                    <td colspan="2"><b>BACK-UP</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">World Specialized Search Engines is not liable for any lost data resulting from the operation of our sites and/or the enforcement of the TCU (including without limitation content from any e-mail account hosted by World Specialized Search Engines, and is not obligated to maintain back-up copies of any contributed User Content or e-mail messages. We recommend that you retain a copy of all User Content that you post or distribute to, or through, the sites. You understand and agree that World Specialized Search Engines may release information about you if required by law or subpoena, or if the information is necessary or appropriate to release to address an unlawful or harmful activity. </td>
                                </tr>
                                <tr>
                                    <td><b>11)</b></td>
                                    <td colspan="2"><b>PASSWORD AND SECURITY</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">From time to time you may receive a password and account designation upon completing the sites' registration process. You are responsible for maintaining the confidentiality of the password and account (if any), and are fully responsible for all activities that occur under your password or account. If a Password is designated, to you will agree to (a) immediately notify World Specialized Search Engines of any unauthorized use of your password or account or any other breach of security, and (b) ensure that you exit from your account at the end of each session. World Specialized Search Engines cannot and will not be liable for any loss or damage arising from your failure to comply with this Section. Without limitation to the generality of the foregoing, due to the nature of Internet, computers, data flow, and other technical and economical practicalities, the sites, like most computer data and Internet applications, is vulnerable to various security issues and hence should be considered unsecured. By using the sites and the Internet in general, you may be subject to various risks, including, among others, eavesdropping, sniffing, spoofing, forgery, spamming, "posturing", tampering, breaking passwords, harassment, fraud, electronic trespassing, hacking, system contamination including without limitation, viruses, worms, trojan horses, causing unauthorized, damaging or harmful access and/or retrieval of information and data on your computer and other forms of activity that may even be considered unlawful. Information (including Registration Data, passwords and User Content) received or delivered or intended to be made available on and through the sites may be subject to these and other security or privacy hazards or may not reach its destination or reach an erroneous address or recipient. The sites are no different than other applications in this respect. Without limitation of the foregoing, although we take seriously the security of all member accounts and other personal and non-personal information associated with our visitors and participants, due to the open communication nature of the Internet, we cannot guarantee that your account will be free from unauthorized access by third parties.</td>
                                </tr>
                                <tr>
                                    <td><b>12)</b></td>
                                    <td colspan="2"><b>EXPORT CONTROLS</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">World Specialized Search Engines encourages users from around the world to use the sites. However, if you choose to use the sites, you understand, acknowledge and agree that your use of the sites is governed by the TCU and the laws and regulations of Australia regarding online conduct and acceptable content. If you use the sites in a jurisdiction that prohibits or restricts the use of the sites, you agree that your use of the sites will be at your own risk, without limitation of any other provision of the TCU, and that World Specialized Search Engines shall not have any liability with respect to such use. Software from these Sites is subject to Australian export controls.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">No software from these sites may be downloaded or otherwise exported or re-exported into any other country to which Australia or the United States has embargoed goods; or to anyone on the Australian or United States Treasury Department's list of Specially Designated Nationals or the United States Commerce Department's Table of Deny Orders. By downloading or using the Software, you represent and warrant that you are not located in, under the control of, or a national or resident of any such country or on any such list.</td>
                                </tr>
                                <tr>
                                    <td><b>13)</b></td>
                                    <td colspan="2"><b>DISCLAIMER OF WARRANTIES</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">You expressly understand and agree that:</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">Your use of the sites is at your sole risk. The sites, and their content, are delivered on an "as is" and "as available" basis. World Specialized Search Engines expressly disclaims all warranties of any kind, whether express or implied, including, but not limited to, the implied warranties of merchantability, fitness for a particular purpose, or non-infringement. World Specialized Search Engines makes no warranty that the sites or any related services, such as email, links, press and media releases, or searches offered on the sites will be error-free, uninterrupted, timely, secure, or that it will provide specific results from use of the sites or any content, search or link therein. World Specialized Search Engines further cannot ensure that files you download from the sites will be free of viruses, trojan horses, bugs, contamination, or destructive features. Any material viewed, downloaded, or otherwise obtained through the use of the sites is done solely at your own discretion and risk, and World Specialized Search Engines will not be liable for any damages of any kind arising from the use of the sites, including, without limitation, direct, indirect, incidental, punitive, or consequential damages. No advice or information, whether oral or written, obtained by you from World Specialized Search Engines or through or from the sites shall create any warranty not expressly stated in the TCU. Data and information relating to securities or otherwise is provided for informational purposes only, and is not intended for trading purposes. Neither World Specialized Search Engines nor any of its data or content providers shall be liable for any errors or delays in the content, or for any actions taken in reliance thereon. </td>
                                </tr>
                                <tr>
                                    <td><b>14)</b></td>
                                    <td colspan="2"><b>LIMITATION OF LIABILITY</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">You expressly understand and agree that World Specialized Search Engines shall not be liable for any indirect, incidental, special, consequential or exemplary damages, including but not limited to, damages for loss of profits, goodwill, use, data or other intangible losses (even if World Specialized Search Engines has been advised of the possibility of such damages), resulting from: (i) the use or the inability to use the sites; (ii) the cost of procurement of substitute goods or services resulting from any goods, data, information or services purchased or obtained or messages received or transactions entered into through or from the sites; (iii) unauthorized access to or alteration of your transmissions or data; </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">(iv) statements or conduct of any third party on the sites; or (v) any other matter relating to the sites or the content thereon, including without limitation any user content posted thereon. In no event will World Specialized Search Engines be liable for any damages in excess of one hundred United States dollars (US$100.00).</td>
                                </tr>
                                <tr>
                                    <td><b>15)</b></td>
                                    <td colspan="2"><b>EXCLUSIONS AND LIMITATIONS</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">Some jurisdictions do not allow the exclusion of certain warranties or the limitation or exclusion of liability for incidental or consequential damages. Accordingly, some of the above limitations may not apply to you.</td>
                                </tr>
                                <tr>
                                    <td><b>16)</b></td>
                                    <td colspan="2"><b>ENTIRE AGREEMENT</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">The TCU constitutes the entire agreement between you and World Specialized Search Engines and governs your use of the sites, superseding any prior agreements between you and World Specialized Search Engines. You may also be subject to additional terms and conditions that may apply when you use affiliate services, third-party content, or third-party software. If any provision of the TCU is found by a court of competent jurisdiction to be invalid, the parties nevertheless agree that the court should endeavor to give effect to the parties' intentions as reflected in the provision, and the other provisions of the TCU remain in full force and effect. You agree that regardless of any statute or law to the contrary, any claim or cause of action arising out of or related to use of the sites or the TCU must be filed within one (1) year after such claim or cause of action arose or be forever barred. The section titles in the TCU are for convenience only and have no legal or contractual effect.</td>
                                </tr>
                                <tr>
                                    <td><b>17)</b></td>
                                    <td colspan="2"><b>TERMS OF SERVICE</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2">The following terms of service may be repetitive of the above terms and conditions of use, however both are applicable to World Specialized Search Engines. World Specialized Search Engines is an on-line data base service ("Service") available over the Internet. As part of our service, World Specialized Search Engines will provide you links to other Web sites and other services that World Specialized Search Engines may decide to offer, subject to the terms hereof. Upon notice published through the Service or otherwise, World Specialized Search Engines may modify this Agreement at any time. You agree and continue to agree to use World Specialized Search Engines' service in a manner consistent with all applicable laws and regulations and in accordance with the terms and conditions set out below.</td>
                                </tr>
                                <tr>
                                    <td><b>18)</b></td>
                                    <td colspan="2"><b>GENERAL TERMS</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>a)</b></td>
                                    <td align="left"><b>USE</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>By using the Service, you agree to be legally bound and to abide by the Terms of Service, just as if you had signed this Agreement. If you do not comply and/or continue to comply with the Terms of Service, World Specialized Search Engines may terminate your right to access the service.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>b)</b></td>
                                    <td align="left"><b>DISCONTINUE USE</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>World Specialized Search Engines may discontinue or alter any aspect of the Service, including, but not limited to either. i) Restricting the availability and/or scope of the Service for certain platforms and operating systems; ii) Restricting the times the service </td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>is available; iii) Restricting the amount of use permitted; and iv) Restricting or terminating any User's right to use the Service, at World Specialized Search Engines' sole discretion and without prior notice or liability. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>c)</b></td>
                                    <td align="left"><b>CHARGES</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>You are responsible for all charges (e.g., telephone) associated with connecting to the Service through an available access number. You are also responsible for obtaining or providing all telephone access lines, telephone and computer equipment (including modem), or other access device, necessary to access the Service.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>d)</b></td>
                                    <td><b>CONTENT</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>You acknowledge that the Service contains information, software, photos, video, graphics, music, sounds or other material (collectively, "Content") that are protected by copyrights, trademarks, trade secrets or other proprietary rights, and that these rights are valid and protected in all forms, media and technologies existing now or hereinafter developed. All Content is copyrighted as a collective work under the Australian copyright laws, and World Specialized Search Engines owns a copyright in the selection, coordination, arrangement and enhancement of such Content. You may not modify, publish, transmit, participate in the transfer or sale, create derivative works, or in any way exploit, any of the Content, in whole or in part. You may not up-load, post, reproduce or distribute Content protected by copyright, or other proprietary right, without obtaining permission of the copyright owner. All trademarks appearing on the Service or links are trademarks of their respective owners.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>e)</b></td>
                                    <td><b>RESPONSIBILITY</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>World Specialized Search Engines claims no responsibility for the accuracy, content, or availability of information accessed or linked to through use of its Service. World Specialized Search Engines encourages its users to determine and abide by the restrictions the authors and providers of linked-to Web sites have placed upon use of the information contained in those Web sites.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>f)</b></td>
                                    <td><b>CONTENT OF USER</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>You will not engage in any conduct that in the discretion of World Specialized Search Engines restricts or inhibits any other person from using or enjoying the Service. You agree to use the Service only for lawful purposes You are prohibited from posting on or transmitting through the Service any unlawful, harmful, threatening, abusive, harassing, defamatory, vulgar, obscene, profane, hateful, racially, ethnically or otherwise objectionable material of any kind, including, but not limited to, any material which encourages conduct that would constitute a criminal offence, give rise to civil liability or otherwise violate any applicable local, state, national or international law. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>g)</b></td>
                                    <td><b>VARIATION OF SERVER</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>World Specialized Search Engines may elect to electronically monitor the Service for adherence to the Terms of Service and may disclose any Content, records or electronic communication of any kind: - i) to satisfy any law, regulation or authorized governmental request; ii) if such disclosure is necessary to operate World Specialized Search Engines; or iii) to protect the rights or property of World Specialized Search Engines or its partners.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><b>h)</b></td>
                                    <td><b>RIGHTS OF WORLD SPECIALIZED SEARCH ENGINES</b></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>World Specialized Search Engines reserves the right to prohibit conduct, communication or Content which it deems in its discretion to be harmful to individual users or other third-party rights, or to violate any applicable law.</td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>19)</b></td>
                                    <td colspan="2"><b>DISCLAIMER OR WARRANTY AND LIMITATION OF LIABILITY</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>a)</b></td>
                                    <td>World Specialized Search Engines' services are provided "as is," without warranty of any kind, either express or implied, including without limitation any warranty for information, services, uninterrupted access, or products provided through or in connection with the service, including without limitation any World Specialized Search Engines software licensed to you and the results obtained through the service. Specifically, World Specialized Search Engines disclaims any and all warranties, including without limitation. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>b)</b></td>
                                    <td>Any warranties concerning the availability, accuracy or content of information, products or services; and </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>c)</b></td>
                                    <td>Any warranties of title or warranties of merchantability or fitness for a particular purpose. You agree that use of the service is entirely at your own risk.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>d)</b></td>
                                    <td>THIS DISCLAIMER OF LIABILITY APPLIES TO ANY DAMAGES OR INJURY CAUSED BY ANY FAILURE OF PERFORMANCE, ERROR, OMISSION, INTERRUPTION, DELETION, DEFECT, DELAY IN OPERATION OR TRANSMISSION, COMPUTER VIRUS, COMMUNICATION LINE FAILURE, THEFT OR DESTRUCTION OR UNAUTHORIZED ACCESS TO, ALTERATION OF, OR USE OF RECORD, WHETHER FOR BREACH OF CONTRACT, TORTUOUS BEHAVIOR, NEGLIGENCE, OR UNDER ANY OTHER CAUSE OF ACTION. YOU SPECIFICALLY ACKNOWLEDGE THAT WORLD SPECIALIZED SEARCH ENGINES IS NOT LIABLE FOR THE DEFAMATORY, OFFENSIVE OR ILLEGAL CONDUCT OF OTHER USERS OR THIRD PARTIES AND THAT THE RISK OF INJURY FROM THE FOREGOING RESTS ENTIRELY WITH YOU.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>e)</b></td>
                                    <td>Neither World Specialized Search Engines nor any of its partners, agents, affiliates or content providers shall be liable for any direct, indirect, incidental, special or consequential damages arising out of use of the service or inability to gain access to or use the service or out of any breach of any warranty. You hereby acknowledge that the provisions of this section shall apply to all content on the service. </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>f)</b></td>
                                    <td>You agree to indemnify and hold World Specialized Search Engines, its partners, agents, affiliates and content partners harmless from any dispute, which may arise from a breach of terms of this agreement. You agree to hold World Specialized Search Engines harmless from any claims and expenses, including reasonable attorney's fees and court costs, related to customer's violation of this agreement, including the terms of service or any content placed on the service by you.</td>
                                </tr>
                                <tr>
                                    <td valign="top"><b>20)</b></td>
                                    <td colspan="2"><b>MISCELLANEOUS</b></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>a)</b></td>
                                    <td>Entire Agreement. This Agreement constitutes the entire agreement between the parties with respect to the subject matter contained herein and supersedes all previous and contemporaneous agreements, proposals and communications, written or oral between World Specialized Search Engines' representatives and you. World Specialized Search Engines may modify this Agreement or impose new conditions at any time upon notice from World Specialized Search Engines to Customer as published through the Service. Any use of the Service by you after such notice shall be deemed to constitute acceptance by you of such amendments, modifications or new conditions.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>b)</b></td>
                                    <td>Independent Contractors. The parties are independent contractors. This Agreement shall not be construed to create a joint venture or partnership between the parties. Neither party shall be deemed to be an employee, agent, partner or legal representative of the other for any purpose and neither shall have any right, power or authority to create any obligation or responsibility on behalf of the other.</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td valign="top"><b>c)</b></td>
                                    <td>Section Headings. The section headings contained herein are for reference purposes only and shall not in any way affect the meaning or interpretation of this agreement.</td>
                                </tr>
                            </table>
                        </td>
					</tr>
				</table>
			</td>

<!-- right column -->

			<td width="200" bgcolor="<?php echo $colour; ?>"><img src="images/trans.gif" width="200"></td>
		</tr>
	</table>

</body>