<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8"> <!-- utf-8 works for most cases -->
	<meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
	<title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

	<!-- Web Font / @font-face : BEGIN -->
	<!-- NOTE: If web fonts are not required, lines 9 - 26 can be safely removed. -->
	
	<!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
	<!--[if mso]>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>
	<![endif]-->
	
	<!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
	<!--[if !mso]><!-->
		<!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
	<!--<![endif]-->

	<!-- Web Font / @font-face : END -->
	
	<!-- CSS Reset -->
    <style type="text/css">

		/* What it does: Remove spaces around the email design added by some email clients. */
		/* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
	        margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        
        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        
        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        
        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
                
        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto; 
        }
        
        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }
        
        /* What it does: A work-around for iOS meddling in triggered links. */
        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }
      
    </style>
    
    <!-- Progressive Enhancements -->
    <style>
        
        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid,
            .fluid-centered {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            /* And center justify these ones. */
            .fluid-centered {
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }
        
            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
                
        }

    </style>

</head>
<body bgcolor="#f0f0f0" width="100%" style="margin: 0;">
    <center style="width: 100%; background: #f0f0f0;">
           
        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;">
            Pick a side, earn points, and get rewarded.
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Email Header : BEGIN -->
      <table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
			<tr>
            <td>
              <hr noshade size="1px" color="#DCDCDC" />
            </td>
            </tr>
            <tr>
				<td style="padding: 20px 0; text-align: center">
					<img src="{{ asset('emails/SidedLogoOneColor_200x25.png') }}" width="200" height="50"  border="0">
				</td>
			</tr>
        </table>
        <!-- Email Header : END -->
        
                <!-- Email Body : BEGIN -->
        <table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            
            <!-- Hero Image, Flush : BEGIN -->            <!-- Hero Image, Flush : END -->

            <!-- 1 Column Text, Flush : BEGIN -->            <!-- 1 Column Text, Flush : END -->
            
            <!-- 1 Column Text with Quoted Text, Flush : BEGIN -->            <!-- 1 Column Text with Quoted Text, Flush : END -->
            
            <!-- 1 Column Text with Headline, Flush : BEGIN -->            <!-- 1 Column Text with Headline, Flush : END -->

            <!-- Background Image with Text : BEGIN -->            <!-- Background Image with Text : END -->
            
             <!-- 1 Column Text : BEGIN -->            <!-- 1 Column Text : END -->

			<!-- Just Button : BEGIN -->            <!-- Just Button : END -->
            
            <!-- Background Image with Text : BEGIN -->            <!-- Background Image with Text : END -->
            
            <!-- 1 Column with Centered Headline : BEGIN -->            <!-- 1 Column with Centered Headline : END -->
            
            <!-- 1 Column with Centered Headline and Small Icon : BEGIN -->
            <?php
                $question_name = DB::table('questions')
                        ->select('questions.*')
                        ->leftJoin('debates', 'questions.id', '=', 'debates.question_id')
                        ->where('debates.id', $debate_id)
                        ->first();
                ?>
            <tr>
                <td width="100%" align="center" valign="top" bgcolor="#ffffff" style="padding: 10px;">
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: 40px 10px 40px 10px; text-align: center">
                                            <a href="https://beta.sided.co"><img src="{{ asset('emails/openicon.png') }}" width="90" height="90"  border="0" class="fluid"></a>
                                        </td>
                                    </tr>
                                    <tr>
									
                                        <td style="font-family: sans-serif; font-weight: bold; font-size: 21px; mso-height-rule: exactly; line-height: 24px; color: #333333; padding: 0 10px 10px; text-align: center;" class="center-on-narrow"><p><span style="font-family: sans-serif; font-weight: bold; font-size: 21px; mso-height-rule: exactly; line-height: 24px; color: #333333; padding: 0 10px 10px; text-align: center;" class="center-on-narrow">Hey {{ ucfirst(trans($take_a_dare_namee)) }},  {{ ucfirst(trans($challenger_name)) }} has challenged you to a debate. The question on Sided is: <a href="{{ route('publicDebateShow', $debate_id)}}" style="color: #61dd50; text-decoration: none;">{{ $question_name->name }}</a> on <a href="https://beta.sided.co" style="color: #61dd50; text-decoration: none;">Sided.</a></span></p></td>

                                    </tr>
                                    <tr>
                                      <td style="font-family: sans-serif; font-weight: bold; font-size: 21px; mso-height-rule: exactly; line-height: 24px; color: #333333; padding: 0 10px 10px; text-align: center;" class="center-on-narrow">
                                      
                                       <!-- Button : Begin -->
                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">

                        <tr>
                            <td style="border-radius: 3px; background: #61dd50; text-align: center;" class="button-td">
                                <a href="{{ route('acceptDebateChallenge') }}?debate_id={{ $encrypted_debate_id }}" style="background: #61dd50; border: 15px solid #61dd50; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Join this Debate</span>&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </td>
                        </tr>
                    </table><br />
                    
              
                                      </td>
                                    </tr>

                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: center;" class="center-on-narrow">
                                            Sided is a platform for fans to debate and discuss current issues with other fans, enthusiasts, and the on-air personalities of the radio programs they listen to. Participate in debates to earn status and opportunities for rewards—and even time on the radio. </span></p>
                  <p>Learn more at <a href="sided.co" style="color: #61dd50; text-decoration: none;">Sided.co</a>.
                    
                  </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- 1 Column with Centered Headline and Small Icon : END -->
           
            <!-- Section : BEGIN -->            <!-- Section : END -->
           
            <!-- Column with Left Headline : BEGIN -->            <!-- 1 Column with Left Headline : END -->
            
            <!-- 1 Column HEadline and Text with Embedded Note Content : BEGIN -->            <!-- 1 Column HEadline and Text with Embedded Note Content : END -->
            
            <!-- 2 Even Columns : BEGIN -->            <!-- 2 Even Columns : END -->

            <!-- 3 Even Columns : BEGIN -->            <!-- 3 Even Columns : END -->
            
            <!-- Thumbnail Left, Text Right : BEGIN -->            <!-- Thumbnail Left, Text Right : END -->

            <!-- Thumbnail Right, Text Left : BEGIN -->            <!-- Thumbnail Right, Text Left : END -->
            
            <!-- Avatar/Icon Left, Text Right : BEGIN -->            <!-- Avatar/Icon Left, Text Right : END -->

            <!-- Clear Spacer : BEGIN -->            <!-- Clear Spacer : END -->

            <!-- 1 Column Text + Button : BEGIN -->
            <tr>
                <td bgcolor="#ffffff">&nbsp;</td>
            </tr>
            <!-- 1 Column Text + Button : BEGIN -->

        </table>
        <!-- Email Body : END -->
      
          
        <!-- Email Footer : BEGIN -->
        <table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            <tr>
                <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                    
                    <br><br>
                    <strong>Sided</strong><br><span class="mobile-link--footer">PO Box 910589, San Diego, CA 92191

contact@sided.co</span><br><span class="mobile-link--footer">(888) 453-4554</span>
                    <br><br> 
                    <a href="#" style="color:#888888; text-decoration:underline;">Manager communication preferences</a>
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->

    </center>
</body>
</html>

