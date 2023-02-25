SELECT 1                                    AS bill_type,
       t1.bestell_datum                     AS old_bill_date,

       -- data for the {{invoices}}
       :CUR_DATE                            AS invoice_date,
       kunde.sprache                        AS invoice_lang,
       kunde.id_kunde                       AS id_kunde,
       kunde.firma                          AS company_name,
       kunde.vorname                        AS first_name,
       kunde.name                           AS second_name,
       kunde.email                          AS email,
       kunde.telefon_mobil                  AS phone,
       kunde.plz                            AS postcode,
       NULL                                 AS country,
       kunde.ortschaft                      AS city,
       kunde.strasse                        AS street,

       -- data for the {{invoice_products}}
       :CUR_DATE                            AS period_start,
       DATE_ADD(:CUR_DATE, INTERVAL 1 YEAR) AS period_end,
       product.abo                          AS product_name,
       1                                    AS product_count,
       t1.preis                             AS product_amount,
       0.00                                 AS product_tax,
       '{{bestellung}}'                     AS product_table,
       t1.id_bestellung                     AS product_id,
       '{{abotyp}}'                         AS product_abo_table,
       product.id_abo                       AS product_abo_id,
       product.prefix                       AS product_prefix,
       product.abobezeichnung               AS product_definition_de,
       product.abobezeichnung_en            AS product_definition_en,
       product.abobezeichnung_fr            AS product_definition_fr,
       product.abobezeichnung_it            AS product_definition_it

FROM {{bestellung}} AS t1
         INNER JOIN {{abotyp}} AS product ON t1.id_abo = product.id_abo
         INNER JOIN {{kunde}} AS kunde ON t1.id_kunde = kunde.id_kunde
WHERE DAY(t1.bestell_datum) = DAY(:FOR_THE_DATE)
  AND MONTH(t1.bestell_datum) = MONTH(:FOR_THE_DATE)
  AND YEAR(t1.bestell_datum) <= YEAR(:FOR_THE_DATE)

UNION

SELECT 3                                    AS bill_type,
       t1.bestell_datum                     AS old_bill_date,

       -- data for the {{invoices}}
       :CUR_DATE                            AS invoice_date,
       kunde.sprache                        AS invoice_lang,
       kunde.id_kunde                       AS id_kunde,
       kunde.firma                          AS company_name,
       kunde.vorname                        AS first_name,
       kunde.name                           AS second_name,
       kunde.email                          AS email,
       kunde.telefon_mobil                  AS phone,
       kunde.plz                            AS postcode,
       NULL                                 AS country,
       kunde.ortschaft                      AS city,
       kunde.strasse                        AS street,

       -- data for the {{invoice_products}}
       :CUR_DATE                            AS period_start,
       DATE_ADD(:CUR_DATE, INTERVAL 1 YEAR) AS period_end,
       product.spezialbestellung            AS product_name,
       1                                    AS product_count,
       t1.preis                             AS product_amount,
       0.00                                 AS product_tax,
       '{{bestellung_spezial}}'             AS product_table,
       t1.id_bestellung_spezial             AS product_id,
       '{{spezial}}'                        AS product_abo_table,
       product.id_spezial                   AS product_abo_id,
       product.prefix                       AS product_prefix,
       product.abobezeichnung               AS product_definition_de,
       product.abobezeichnung_en            AS product_definition_en,
       product.abobezeichnung_fr            AS product_definition_fr,
       product.abobezeichnung_it            AS product_definition_it

FROM {{bestellung_spezial}} AS t1
         INNER JOIN {{spezial}} AS product ON t1.id_spezial = product.id_spezial
         INNER JOIN {{kunde}} AS kunde ON t1.id_kunde = kunde.id_kunde
WHERE DAY(t1.bestell_datum) = DAY(:FOR_THE_DATE)
  AND MONTH(t1.bestell_datum) = MONTH(:FOR_THE_DATE)
  AND YEAR(t1.bestell_datum) <= YEAR(:FOR_THE_DATE)

UNION

SELECT 4                                    AS bill_type,
       t1.bestell_datum                     AS old_bill_date,

       -- data for the {{invoices}}
       :CUR_DATE                            AS invoice_date,
       kunde.sprache                        AS invoice_lang,
       kunde.id_kunde                       AS id_kunde,
       kunde.firma                          AS company_name,
       kunde.vorname                        AS first_name,
       kunde.name                           AS second_name,
       kunde.email                          AS email,
       kunde.telefon_mobil                  AS phone,
       kunde.plz                            AS postcode,
       NULL                                 AS country,
       kunde.ortschaft                      AS city,
       kunde.strasse                        AS street,

       -- data for the {{invoice_products}}
       :CUR_DATE                            AS period_start,
       DATE_ADD(:CUR_DATE, INTERVAL 1 YEAR) AS period_end,
       product.service                      AS product_name,
       1                                    AS product_count,
       t1.preis                             AS product_amount,
       0.00                                 AS product_tax,
       '{{bestellung_ssl}}'                 AS product_table,
       t1.id_bestellung_ssl                 AS product_id,
       '{{ssl}}'                            AS product_abo_table,
       product.id_ssl                       AS product_abo_id,
       product.prefix                       AS product_prefix,
       product.abobezeichnung               AS product_definition_de,
       product.abobezeichnung_en            AS product_definition_en,
       product.abobezeichnung_fr            AS product_definition_fr,
       product.abobezeichnung_it            AS product_definition_it

FROM {{bestellung_ssl}} AS t1
         INNER JOIN {{ssl}} AS product ON t1.id_ssl = product.id_ssl
         INNER JOIN {{kunde}} AS kunde ON t1.id_kunde = kunde.id_kunde
WHERE DAY(t1.bestell_datum) = DAY(:FOR_THE_DATE)
  AND MONTH(t1.bestell_datum) = MONTH(:FOR_THE_DATE)
  AND YEAR(t1.bestell_datum) <= YEAR(:FOR_THE_DATE)

ORDER BY id_kunde ASC, bill_type ASC, product_id ASC
