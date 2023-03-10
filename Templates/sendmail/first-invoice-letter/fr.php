<?php
return [
    /**/
    'from_email' => "test@hoststar.ch",
    'from_name' => "Test Hoststar",
    'cc' => "",
    'bcc' => "",
    'reply_to' => "",
    'subject' => "[company_name] - Renouvellement [SWITCH_ABO_BETREFF]",

    /**/
    'html' => '
<div style="text-align: center;">
<table class="container" style="width: 490pt!important; width: 490pt; margin-left: auto; margin-right: auto; text-align: left;">
	<tbody>
		<tr>
			<td style="padding-bottom: 13px; page-break-inside: avoid;">
			<div style="text-align: left;">
			<h1 class="title" style="font-weight: bold; font-size: 16.0pt; text-transform: uppercase; letter-spacing: 1.5pt; margin-bottom: 15px; font-family: Calibri,sans-serif;">[company_name]</h1>

			<table class="grayline" style="text-align: right; width: 100%!important; width: 100%; border: solid #d9d9d9 1.0pt; border-collapse: collapse; border-top: none; border-bottom: none;">
				<tbody>
					<tr>
						<td class="grayline" style="background-color: #d9d9d9; padding-right: 5.4pt; padding-left: 5.4pt; height: 13pt;"><span class="grayline_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; font-weight: bold; color: black; text-transform: uppercase; letter-spacing: .5pt">[SWITCH_RECHNUNGSSTATUS_TITEL]</span></td>
					</tr>
				</tbody>
			</table>
			</div>
			</td>
		</tr>
		<tr>
			<td style="padding-bottom: 13px; page-break-inside: avoid;">
			<table class="borderbox" style="border: solid #d9d9d9 1.0pt; width: 100%; border-collapse: collapse;">
				<tbody>
					<tr>
						<td class="borderbox" style="padding: 22.7pt; text-align: left;"><span class="running_text_intro" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; font-weight: bold; color: black;">[ANREDE]</span>
						<p class="running_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: #595959;">[SWITCH_RECHNUNGSSTATUS_EINLEITUNG]<br />
						&nbsp;</p>

						<p class="running_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: #595959;">Meilleures salutations,</p>

						<p class="running_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: #595959;">L&#39;&eacute;quipe [company_name]</p>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td style="padding-bottom: 13px">
			<table class="borderbox" style="border: solid #d9d9d9 1.0pt; width: 100%; border-collapse: collapse;">
				<tbody>
					<tr>
						<td class="borderbox" style="padding: 22.7pt; border-collapse: separate;">
						<table class="grayline" style="text-align: left; width: 100%; border: solid #d9d9d9 1.0pt; border-collapse: collapse; border-top: none; border-bottom: none;">
							<tbody>
								<tr>
									<td class="grayline" style="background-color: #d9d9d9; padding-right: 5.4pt; padding-left: 5.4pt;"><span class="grayline_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; font-weight: bold; color: black; text-transform: uppercase; letter-spacing: .5pt">[SWITCH_RECHNUNGSSTATUS_TITEL2]</span></td>
								</tr>
							</tbody>
						</table>
						&nbsp;

						<table style="width: 100%;">
							<tbody>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Date de facture</span></td>
									<td class="light_gray" style="border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[RECHNUNGSDATUM]</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Destinataire de la facture</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 2px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[FIRMA]</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[VORNAME] [NACHNAME]</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[STRASSE]</span></td>
								</tr>
								<!--START_LAND_CUTOUT-->
								<tr>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[PLZ] [ORT]</span></td>
								</tr>
								<!--END_LAND_CUTOUT-->
								<tr>
									<td class="light_gray" style="border-bottom: 12px solid white"></td>
									<td class="light_gray" style="border-bottom: 12px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[LAND_GROSS]</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[SWITCH_ABO_ABOTYP]</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[ABOTYP] ([ABOBEZEICHNUNG])</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[SWITCH_ABO_PRODUKTMERKMAL]</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[SWITCH_ABO_PRODUKTMERKMAL_WERT]</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Num&eacute;ro de commande</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[PREFIX][BESTELLNUMMER]</span></td>
								</tr>
								<!--START_LAUFZEIT_CUTOUT-->
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Dur&eacute;e</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[LAUFZEIT_VON] - [LAUFZEIT_BIS]</span></td>
								</tr>
								<!--END_LAUFZEIT_CUTOUT-->
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;"><b>Montant total de la facture</b></span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;"><b>[WAEHRUNG] [PREIS] par an</b> TVA de&nbsp;[MWST]% incluse ([WAEHRUNG] [MWST_BETRAG])</span></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td style="padding-bottom: 13px; page-break-inside: avoid;">
			<table class="borderbox" style="border: solid #d9d9d9 1.0pt; width: 100%; border-collapse: collapse;">
				<tbody>
					<tr>
						<td class="borderbox" style="padding: 22.7pt; border-collapse: separate;">
						<table class="grayline" style="text-align: left; width: 100%; border: solid #d9d9d9 1.0pt; border-collapse: collapse; border-top: none; border-bottom: none;">
							<tbody>
								<tr>
									<td class="grayline" style="background-color: #d9d9d9; padding-right: 5.4pt; padding-left: 5.4pt;"><span class="grayline_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; font-weight: bold; color: black; text-transform: uppercase; letter-spacing: .5pt">Pour tout paiement par carte de cr&eacute;dit ou Postcard</span></td>
								</tr>
							</tbody>
						</table>
						&nbsp;

						<table style="width: 100%; border-collapse: collapse; vertical-align: top; text-align: center;">
							<tbody>
								<tr>
									<td></td>
									<td style="background-color:#1f2226; border-top:1px solid #464b4f; border-left: 1px solid #464b4f; border-bottom: 1px solid #888888; border-right: 1px solid #888888; cursor:pointer; color:#ffffff; display:inline-block; text-align: center; width: 303px!important; width: 303px; padding-bottom: 3px;"><a href="[CC_LINK]" style="color:#ffffff; font-family:Calibri; font-weight: bold; text-transform: uppercase; letter-spacing: .5pt; font-size: 10pt; text-decoration: none;">Payer par carte de cr&eacute;dit</a></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td style="padding-bottom: 13px;">
			<table class="borderbox" style="border: solid #d9d9d9 1.0pt; width: 100%; border-collapse: collapse;">
				<tbody>
					<tr>
						<td class="borderbox" style="padding: 22.7pt; border-collapse: separate;">
						<table class="grayline" style="text-align: left; width: 100%; border: solid #d9d9d9 1.0pt; border-collapse: collapse; border-top: none; border-bottom: none;">
							<tbody>
								<tr>
									<td class="grayline" style="background-color: #d9d9d9; padding-right: 5.4pt; padding-left: 5.4pt;"><span class="grayline_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; font-weight: bold; color: black; text-transform: uppercase; letter-spacing: .5pt">Paiement par service bancaires en ligne</span></td>
								</tr>
							</tbody>
						</table>
						&nbsp;

						<table style="width: 100%;">
							<tbody>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Paiement pour</span></td>
									<td class="light_gray" style="border-bottom: 2px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[company_name]</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Kirchgasse 30</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="border-bottom: 2px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 2px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">3312 Fraubrunnen</span></td>
								</tr>
								<tr>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Num&eacute;ro IDE</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">CHE-112.417.413 TVA</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Compte postal</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">30-164078-4</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Num&eacute;ro de compte (format IBAN)</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">CH9009000000301640784</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">N&deg; de clearing</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">09000</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 2px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">SWIFT-BIC</span></td>
									<td class="light_gray" style="border-top: 12px solid white; border-bottom: 2px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white; border-bottom: 2px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">POFICHBEXXX</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="border-bottom: 12px solid white"></td>
									<td class="light_gray" style="border-bottom: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-bottom: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">Postfinance AG, 3030 Bern</span></td>
								</tr>
								<tr>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">D&eacute;lai de paiement</span></td>
									<td class="light_gray" style="border-top: 12px solid white;"></td>
									<td class="light_gray" style="background-color: #f2f2f2; height: 12.5pt; width: 49%; padding-right: 5.4pt; padding-left: 5.4pt; border-top: 12px solid white;"><span class="graycell_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: black;">[SWITCH_RECHNUNGSSTATUS_FRIST]</span></td>
								</tr>
							</tbody>
						</table>

						<p class="running_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: #595959;"><b>IMPORTANT:</b><br />
						Veuillez indiquer les informations suivantes dans la<br />
						rubrique &laquo;Remarques&raquo; lors du paiement:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>[SWITCH_ABO_PRODUKTMERKMAL_WERT2] - [SWITCH_ABO_PRODUKTMERKMAL_WERT]</b></p>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td style="padding-bottom: 13px; page-break-inside: avoid;">
			<table class="borderbox" style="border: solid #d9d9d9 1.0pt; width: 100%; border-collapse: collapse;">
				<tbody>
					<tr>
						<td class="borderbox" style="padding: 22.7pt; border-collapse: separate;">
						<p class="running_text" style="font-family: Calibri,sans-serif; letter-spacing: .3pt; font-size: 10.0pt; color: #595959;">[SWITCH_RECHNUNGSSTATUS_INFO][SWITCH_ABO_LOESCHINSTRUKTIONEN]Si vous souhaitez que nous vous transmettions dor&eacute;navant les informations concernant le renouvellement de votre contrat &agrave; une autre adresse e-mail, veuillez actualiser vos donn&eacute;es personnelles dans la section [company_name]: <a href="https://my.hoststar.ch">https://my.hoststar.ch</a>.</p>
						</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
		<tr>
			<td style="page-break-inside: avoid; padding-bottom: 10px;"><!--SIGNATURE_PLACEHOLDER--></td>
		</tr>
	</tbody>
</table>
</div>
',
];