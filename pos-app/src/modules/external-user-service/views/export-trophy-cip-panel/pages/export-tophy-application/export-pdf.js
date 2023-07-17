import i18n from '@/i18n'
import Store from '@/store'
import pdfMake from 'pdfmake/build/pdfmake'
import pdfFontsBn from 'pdfmake/build/vfs_fonts_bn'
import pdfFontsEn from 'pdfmake/build/vfs_fonts_en'

function mobileNumber (value) {
  try {
      if (typeof value !== 'undefined' && value) {
         if (i18n.locale === 'bn') {
             return '০' + i18n.n(value, { useGrouping: false })
         } else {
          return '0' + i18n.n(value, { useGrouping: false })
      }
      }
  } catch (e) {
      return value
  }
}

function destinationRow (designations, vm) {
  const loopData = JSON.parse(designations)
  let customizeData = ''
  loopData.forEach((el, indx) => {
    customizeData = customizeData + vm.destinationName(parseInt(el))
    if (loopData.length !== (indx + 1)) {
      customizeData = customizeData + ', '
    }
  })
  return customizeData
}

const exportPdfDetails = async (reportTitle, vm) => {
    try {
        Store.commit('mutateCommonProperties', {
            loading: true
        })
        if (i18n.locale === 'bn') {
            pdfMake.vfs = pdfFontsBn.pdfMake.vfs
        } else {
            pdfMake.vfs = pdfFontsEn.pdfMake.vfs
        }
        const pdfContent = []
        pdfContent.push(
            { text: reportTitle, style: 'header', alignment: 'center' }
        )
        // Tab-1: Basic Information
        pdfContent.push({ text: '', marginBottom: 3 })
        pdfContent.push({ text: vm.$t('globalTrans.basic_information'), style: 'my_title' })
        const topRows = [
          [
            { text: vm.$t('exportTrophyCircular.circular'), bold: true, style: 'td' },
            { text: vm.currentLocale === 'bn' ? vm.application.circular.title_bn : vm.application.circular.title_en, style: 'td' },
            { text: vm.$t('exportTrophyCircular.memo_no'), bold: true, style: 'td' },
            { text: vm.application.circular.memo_no, style: 'td' }
          ],
          [
            { text: vm.$t('externalUser.export_product_sector'), bold: true, style: 'td' },
            { text: vm.productName(vm.application.product_service_sector_id), style: 'td' },
            { text: vm.$t('externalUser.latent_exporter'), bold: true, style: 'td' },
            { text: vm.getLatentExporter(vm.application.latent_exporter), style: 'td' }
          ],
          [{}, {}, {}, {}],
          [{}, {}, {}, {}],
          [
            { text: vm.$t('externalUser.org_info') + ' ' + vm.$t('globalTrans.information'), colSpan: '4', bold: true, style: 'mytd' },
            {},
            {},
            {}
          ],
          [
            { text: vm.$t('externalUser.org_name'), bold: true, style: 'td' },
            { text: vm.currentLocale === 'bn' ? vm.application.org_info.org_name_bn : vm.application.org_info.org_name_en, style: 'td' },
            { text: vm.$t('externalUser.bin_no'), bold: true, style: 'td' },
            { text: vm.$n(vm.application.org_info.bin_no, { useGrouping: false }), style: 'td' }
          ],
          [
            { text: vm.$t('externalUser.org_type'), bold: true, style: 'td' },
            { text: vm.orgTypeName(vm.application.org_info.org_type), style: 'td' },
            { text: vm.$t('externalUser.epz_affiliated_org'), bold: true, style: 'td' },
            { text: parseInt(vm.application.org_info.epz_affiliated_org) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
          ],
          [
            { text: vm.$t('externalUser.bangladeshi_owned_compnay'), bold: true, style: 'td', colSpan: '3' },
            {},
            {},
            { text: parseInt(vm.application.org_info.bangladeshi_owned_company) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
          ],
          [
            { text: vm.$t('externalUser.org_address'), bold: true, style: 'td' },
            { text: vm.AddressHelper.getPresentAddress(vm.org_address), style: 'td', colSpan: '3' },
            {},
            {}
          ],
          [{}, {}, {}, {}],
          [{}, {}, {}, {}],
          [
            { text: vm.$t('externalUser.org_tax_info'), colSpan: '4', bold: true, style: 'mytd' },
            {},
            {},
            {}
          ],
          [
            { text: vm.$t('externalUser.tin_no'), bold: true, style: 'td' },
            { text: vm.$n(vm.application.org_tax_info.tin_no, { useGrouping: false }), style: 'td' },
            { text: vm.$t('externalUser.tax_circle'), bold: true, style: 'td' },
            { text: vm.application.org_tax_info.tax_circle, style: 'td' }
          ],
          [
            { text: vm.$t('externalUser.tax_region'), bold: true, style: 'td' },
            { text: vm.currentLocale === 'bn' ? vm.application.org_tax_info.tax_region_bn : vm.application.org_tax_info.tax_region_en, style: 'td', colSpan: '3' },
            {},
            {}
          ],
          [{}, {}, {}, {}],
          [{}, {}, {}, {}],
          [
            { text: vm.$t('externalUser.office_contact_info'), colSpan: '4', bold: true, style: 'mytd' },
            {},
            {},
            {}
          ],
          [
            { text: vm.$t('externalUser.telephone_no'), bold: true, style: 'td' },
            { text: vm.$n(vm.application.office_contact_info.telephone_no, { useGrouping: false }), style: 'td' },
            { text: vm.$t('globalTrans.mobile'), bold: true, style: 'td' },
            { text: mobileNumber(vm.application.office_contact_info.mobile_no), style: 'td' }
          ],
          [
            { text: vm.$t('globalTrans.email'), bold: true, style: 'td' },
            { text: vm.application.office_contact_info.email, style: 'td' },
            { text: vm.$t('externalUser.fax_no'), bold: true, style: 'td' },
            { text: vm.$n(vm.application.office_contact_info.fax_no, { useGrouping: false }), style: 'td' }
          ],
          [{}, {}, {}, {}],
          [{}, {}, {}, {}],
          [
            { text: vm.$t('externalUser.factory_contact_info'), colSpan: '4', bold: true, style: 'mytd' },
            {},
            {},
            {}
          ],
          [
            { text: vm.$t('externalUser.telephone_no'), bold: true, style: 'td' },
            { text: vm.$n(vm.application.factory_contact_info.telephone_no, { useGrouping: false }), style: 'td' },
            { text: vm.$t('globalTrans.mobile'), bold: true, style: 'td' },
            { text: mobileNumber(vm.application.factory_contact_info.mobile_no), style: 'td' }
          ],
          [
            { text: vm.$t('globalTrans.email'), bold: true, style: 'td' },
            { text: vm.application.factory_contact_info.email, style: 'td' },
            { text: vm.$t('externalUser.fax_no'), bold: true, style: 'td' },
            { text: vm.$n(vm.application.factory_contact_info.fax_no, { useGrouping: false }), style: 'td' }
          ],
          [{}, {}, {}, {}],
          [{}, {}, {}, {}],
          [
            { text: vm.$t('externalUser.contact_person_info'), colSpan: '4', bold: true, style: 'mytd' },
            {},
            {},
            {}
          ],
          [
            { text: vm.$t('globalTrans.name'), bold: true, style: 'td' },
            { text: vm.currentLocale === 'en' ? vm.application.contact_person_info.name_en : vm.application.contact_person_info.name_bn, style: 'td' },
            { text: vm.$t('globalTrans.designation'), bold: true, style: 'td' },
            { text: vm.currentLocale === 'bn' ? vm.application.contact_person_info.designation_bn : vm.application.contact_person_info.designation_en, style: 'td' }
          ],
          [
            { text: vm.$t('globalTrans.mobile'), bold: true, style: 'td' },
            { text: mobileNumber(vm.application.contact_person_info.mobile), style: 'td', colSpan: '3' },
            {},
            {}
          ]
        ]
        pdfContent.push({
          table: {
            headerRows: 1,
            widths: '25%',
            body: topRows
          },
          layout: {
            hLineWidth: function (i, node) {
              return 0
            },
            vLineWidth: function (i, node) {
              return 0
            }
          }
        })
        // Tab-2: Applicants Address
        if (vm.application.address !== null) {
          pdfContent.push({ text: '', marginBottom: 3 })
          pdfContent.push({ text: vm.$t('externalUser.org_address'), style: 'my_title' })
          const Address = [
            [
              { text: vm.$t('globalTrans.present_address'), bold: true, style: 'td' },
              { text: vm.AddressHelper.getPresentAddress(vm.application.address), style: 'td', colSpan: '3' },
              {},
              {}
            ],
            [
              { text: vm.$t('globalTrans.permanent_address'), bold: true, style: 'td' },
              { text: vm.AddressHelper.getPermanentAddress(vm.application.address), style: 'td', colSpan: '3' },
              {},
              {}
            ]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: Address
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
        }

        pdfContent.push({ text: '', pageOrientation: 'portrait', pageBreak: 'after' })
        // Tab-3: Organization Info
        if (vm.application.owner_info !== null) {
          pdfContent.push({ text: '', marginBottom: 3 })
          pdfContent.push({ text: vm.$t('externalUser.org_owner_info'), style: 'my_title' })
          const OrgInfo = [
            [
              { text: vm.$t('externalUser.et_application') + ' ' + vm.$t('globalTrans.name'), bold: true, style: 'td' },
              { text: vm.currentLocale === 'bn' ? vm.application.owner_info.owner_name_bn : vm.application.owner_info.owner_name_en, style: 'td' },
              { text: vm.$t('globalTrans.father_name'), bold: true, style: 'td' },
              { text: vm.currentLocale === 'bn' ? vm.application.owner_info.father_husband_name_bn : vm.application.owner_info.father_husband_name_en, style: 'td' }
            ],
            [
              { text: vm.$t('globalTrans.mother_name'), bold: true, style: 'td' },
              { text: vm.currentLocale === 'bn' ? vm.application.owner_info.mother_name_bn : vm.application.owner_info.mother_name_en, style: 'td' },
              { text: vm.$t('globalTrans.designation'), bold: true, style: 'td' },
              { text: vm.currentLocale === 'bn' ? vm.application.owner_info.designation_bn : vm.application.owner_info.designation_en, style: 'td' }
            ],
            [
              { text: vm.$t('globalTrans.dob'), bold: true, style: 'td' },
              { text: vm.$d(new Date(vm.application.owner_info.dob)), style: 'td' },
              { text: vm.$t('globalTrans.nid'), bold: true, style: 'td' },
              { text: vm.$n(vm.application.owner_info.nid_no, { useGrouping: false }), style: 'td' }
            ],
            [
              { text: vm.$t('externalUser.smart_id_no'), bold: true, style: 'td' },
              { text: vm.$n(vm.application.owner_info.smart_id_no, { useGrouping: false }), style: 'td' },
              {},
              {}
            ],
            [{}, {}, {}, {}],
            [{}, {}, {}, {}]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: OrgInfo
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
          // if (vm.application.passport_info !== null) {
            const OrgInfo2 = [
              [
                { text: vm.$t('externalUser.org_owner_passport_info'), colSpan: '4', bold: true, style: 'mytd' },
                {},
                {},
                {}
              ],
              [
                { text: vm.$t('externalUser.passport_no'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.passport_info.passport_no, { useGrouping: false }), style: 'td' },
                { text: vm.$t('externalUser.issuing_country'), bold: true, style: 'td' },
                { text: vm.countryName(vm.application.passport_info.country_id), style: 'td' }
              ],
              [
                { text: vm.$t('externalUser.issue_date'), bold: true, style: 'td' },
                { text: vm.$d(new Date(vm.application.passport_info.issue_date)), style: 'td' },
                { text: vm.$t('externalUser.duration'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.passport_info.duration, { useGrouping: false }), style: 'td' }
              ],
              [{}, {}, {}, {}],
              [{}, {}, {}, {}],
              [
                { text: vm.$t('externalUser.owner_tax_info'), colSpan: '4', bold: true, style: 'mytd' },
                {},
                {},
                {}
              ],
              [
                { text: vm.$t('externalUser.tin_no'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.tax_info.tin_no, { useGrouping: false }), style: 'td' },
                { text: vm.$t('externalUser.tax_circle'), bold: true, style: 'td' },
                { text: vm.application.tax_info.tax_circle, style: 'td' }
              ],
              [
                { text: vm.$t('externalUser.tax_region'), bold: true, style: 'td' },
                { text: vm.currentLocale === 'bn' ? vm.application.tax_info.tax_region_bn : vm.application.tax_info.tax_region_en, style: 'td', colSpan: '3' },
                {},
                {}
              ],
              [{}, {}, {}, {}],
              [{}, {}, {}, {}],
              [
                { text: vm.$t('externalUser.owner_contact_info'), colSpan: '4', bold: true, style: 'mytd' },
                {},
                {},
                {}
              ],
              [
                { text: vm.$t('externalUser.telephone_no'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.contact_info.telephone_no, { useGrouping: false }), style: 'td' },
                { text: vm.$t('globalTrans.mobile'), bold: true, style: 'td' },
                { text: mobileNumber(vm.application.contact_info.mobile_no), style: 'td' }
              ],
              [
                { text: vm.$t('globalTrans.email'), bold: true, style: 'td' },
                { text: vm.application.contact_info.email, style: 'td' },
                { text: vm.$t('externalUser.fax_no'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.contact_info.fax_no, { useGrouping: false }), style: 'td' }
              ]
            ]
            pdfContent.push({
              table: {
                headerRows: 1,
                widths: '25%',
                body: OrgInfo2
              },
              layout: {
                hLineWidth: function (i, node) {
                  return 0
                },
                vLineWidth: function (i, node) {
                  return 0
                }
              }
            })
          // }
          if (parseInt(vm.application.passport_info.women_entrepreneur) === 1) {
            const OrgInfo3 = [
              [
                { text: vm.$t('externalUser.entrepreneur'), colSpan: '4', bold: true, style: 'mytd' },
                {},
                {},
                {}
              ],
              [
                { text: vm.$t('externalUser.et_applicants_name'), bold: true, style: 'td' },
                { text: vm.currentLocale === 'bn' ? vm.application.entrepreneurs.name_bn : vm.application.entrepreneurs.name_en, style: 'td' },
                { text: vm.$t('globalTrans.designation'), bold: true, style: 'td' },
                { text: vm.currentLocale === 'bn' ? vm.application.entrepreneurs.designation_bn : vm.application.entrepreneurs.designation_en, style: 'td' }
              ],
              [
                { text: vm.$t('externalUser.license_no'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.entrepreneurs.license_no, { useGrouping: false }), style: 'td' },
                { text: vm.$t('externalUser.update_license_no'), bold: true, style: 'td' },
                { text: vm.$n(vm.application.entrepreneurs.license, { useGrouping: false }), style: 'td' }
              ],
              [
                { text: vm.$t('externalUser.certification_of_concern_bank'), bold: true, style: 'td' },
                { text: vm.application.entrepreneurs.certificate, style: 'td' },
                { text: vm.$t('externalUser.direct_involved_bussness'), bold: true, style: 'td' },
                { text: parseInt(vm.application.entrepreneurs.directly_involced_business) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
              ],
              [
                { text: vm.$t('externalUser.name_of_porduct_and_service'), bold: true, style: 'td' },
                { text: vm.getProductServiceList(vm.application.entrepreneurs.product_service_name_details), style: 'td', colSpan: 3 },
                {},
                {}
              ]
            ]
            pdfContent.push({
              table: {
                headerRows: 1,
                widths: '25%',
                body: OrgInfo3
              },
              layout: {
                hLineWidth: function (i, node) {
                  return 0
                },
                vLineWidth: function (i, node) {
                  return 0
                }
              }
            })
          }
        }
        pdfContent.push({ text: '', pageOrientation: 'portrait', pageBreak: 'after' })
        // Tab-5: List of Banks
        if (vm.application.bank.length > 0) {
          pdfContent.push({ text: '', marginBottom: 3 })
          pdfContent.push({ text: vm.$t('externalUser.bank_list'), style: 'my_title' })
          const Banks = [
            [
              { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.bank_name'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.branch_name'), style: 'th', alignment: 'center' },
              { text: vm.$t('globalTrans.address'), style: 'th', alignment: 'center' }
            ]
          ]
          vm.application.bank.forEach((item, index) => {
            Banks.push([
              { text: vm.$n(index + 1), style: 'td', alignment: 'center' },
              { text: vm.currentLocale === 'bn' ? item.bank_name_bn : item.bank_name_en, style: 'td', alignment: 'center' },
              { text: vm.currentLocale === 'bn' ? item.branch_name_bn : item.branch_name_en, style: 'td', alignment: 'center' },
              { text: vm.currentLocale === 'bn' ? item.address_bn : item.address_en, style: 'td', alignment: 'center' }
            ])
          })
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: ['10%', '*', '*', '*'],
              body: Banks
            }
          })
        }

        // Tab-6: Product Description
        if (vm.application.product_success_description.length > 0) {
          pdfContent.push({ text: '', marginBottom: 3 })
          pdfContent.push({ text: vm.$t('externalUser.export_product_and_success'), style: 'my_title' })
          const Description = [
            [
              { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.export_product_name'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.export_destinations'), style: 'th', alignment: 'center' },
              { text: vm.$t('globalTrans.fiscal_year'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.export_volume'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.export_value_usd'), style: 'th', alignment: 'center' },
              { text: vm.$t('externalUser.income_growth'), style: 'th', alignment: 'center' }
            ]
          ]
          vm.application.product_success_description.forEach((item, index) => {
            Description.push([
              { text: vm.$n(index + 1), style: 'td', alignment: 'center' },
              { text: vm.productName(item.product_id), style: 'td', alignment: 'center' },
              { text: destinationRow(item.destination_id, vm), style: 'td', alignment: 'center' },
              { text: vm.fiscalYearName(item.fiscal_year_id), style: 'td', alignment: 'center' },
              { text: vm.$n(item.export_volume, { useGrouping: false }), style: 'td', alignment: 'center' },
              { text: vm.$n(item.export_value_ssd, { useGrouping: false }), style: 'td', alignment: 'center' },
              { text: vm.$n(item.income_growth, { useGrouping: false }), style: 'td', alignment: 'center' }
            ])
          })
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: ['7%', '*', '*', '*', '*', '*', '*'],
              body: Description
            }
          })
        }
        pdfContent.push({ text: '', pageOrientation: 'portrait', pageBreak: 'after' })
        // Tab-7: Others Compliance Info
        if (vm.application.other_compliance !== null) {
          pdfContent.push({ text: '', marginBottom: 3 })
          pdfContent.push({ text: vm.$t('externalUser.compliance_information'), style: 'my_title' })
          const Compliance = [
            [
              { text: vm.$t('externalUser.export_leather_shoes'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.export_leather_shoes) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [{}, {}, {}, {}],
            [
              { text: vm.$t('externalUser.org_compliance_information'), colSpan: '4', bold: true, style: 'mytd' },
              {},
              {},
              {}
            ],
            [
              { text: vm.$t('externalUser.compliance_current_fiscal_year'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.compliance_current_fiscal_year) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [
              { text: vm.$t('externalUser.merchandising_sector'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: vm.merchandisingSectorName(vm.application.other_compliance.merchandising_sector), style: 'td' }
            ],
            [{}, {}, {}, {}],
            [{}, {}, {}, {}]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: Compliance
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
          // Export destinatio add
          const DestinationAdd = [
            [
              { text: vm.$t('externalUser.export_destination_add'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.export_destination_add) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [{}, {}, {}, {}]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: DestinationAdd
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
          // add export destination details
          if (parseInt(vm.application.other_compliance.export_destination_add) === 1) {
            const Item1 = [
              [
                { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'center' },
                { text: vm.$t('globalTrans.country'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.prc_no'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.buyer_org_name'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.prc_date'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.realization_date'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.export_value_usd'), style: 'th', alignment: 'center' }
              ]
            ]
            vm.application.export_destination.forEach((item, index) => {
              Item1.push([
                { text: vm.$n(index + 1), style: 'td', alignment: 'center' },
                { text: vm.countryName(item.country_id), style: 'td', alignment: 'center' },
                { text: vm.$n(item.prc_no, { useGrouping: false }), style: 'td', alignment: 'center' },
                { text: vm.currentLocale === 'en' ? item.buyer_org_name_en : item.buyer_org_name_bn, style: 'td', alignment: 'center' },
                { text: vm.$d(new Date(item.prc_date)), style: 'td', alignment: 'center' },
                { text: vm.$d(new Date(item.realization_date)), style: 'td', alignment: 'center' },
                { text: vm.$n(item.export_value_usd, { useGrouping: false }), style: 'td', alignment: 'center' }
              ])
            })
            pdfContent.push({
              table: {
                headerRows: 1,
                widths: ['8%', '*', '*', '*', '*', '*', '*'],
                body: Item1
              }
            })
          }

          // Export destinatio add
          const ProductAdd = [
            [{}, {}, {}, {}],
            [{}, {}, {}, {}],
            [
              { text: vm.$t('externalUser.export_products_add'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.export_products_add) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [{}, {}, {}, {}]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: ProductAdd
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
          // add export product details
          if (parseInt(vm.application.other_compliance.export_products_add) === 1) {
            const Item2 = [
              [
                { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.product_name'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.prc_no'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.hs_code'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.prc_date'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.realization_date'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.export_value_usd'), style: 'th', alignment: 'center' }
              ]
            ]
            vm.application.export_product.forEach((item, index) => {
              Item2.push([
                { text: vm.$n(index + 1), style: 'td', alignment: 'center' },
                { text: vm.productName(item.product_id), style: 'td', alignment: 'center' },
                { text: vm.$n(item.prc_no, { useGrouping: false }), style: 'td', alignment: 'center' },
                { text: item.hs_code, style: 'td', alignment: 'center' },
                { text: vm.$d(new Date(item.prc_date)), style: 'td', alignment: 'center' },
                { text: vm.$d(new Date(item.realization_date)), style: 'td', alignment: 'center' },
                { text: vm.$n(item.export_value_usd, { useGrouping: false }), style: 'td', alignment: 'center' }
              ])
            })
            pdfContent.push({
              table: {
                headerRows: 1,
                widths: ['8%', '*', '*', '*', '*', '*', '*'],
                body: Item2
              }
            })
          }

          // Export Cip Selected add
          const EtSelected = [
            [{}, {}, {}, {}],
            [{}, {}, {}, {}],
            [
              { text: vm.$t('externalUser.applicant_selected_et_past_year'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.applicant_selected_et_past_year) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [{}, {}, {}, {}]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: EtSelected
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
          // add export product details
          if (parseInt(vm.application.other_compliance.applicant_selected_et_past_year) === 1) {
            const Item3 = [
              [
                { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.selection_year'), style: 'th', alignment: 'center' },
                { text: vm.$t('externalUser.product_name'), style: 'th', alignment: 'center' }
              ]
            ]
            vm.application.et_selected.forEach((item, index) => {
              Item3.push([
                { text: vm.$n(index + 1), style: 'td', alignment: 'center' },
                { text: vm.$n(item.selection_year, { useGrouping: false }), style: 'td', alignment: 'center' },
                { text: vm.productName(item.product_sector_id), style: 'td', alignment: 'center' }
              ])
            })
            pdfContent.push({
              table: {
                headerRows: 1,
                widths: ['10%', '*', '*'],
                body: Item3
              }
            })
          }

          const Compliance2 = [
            [{}, {}, {}, {}],
            [{}, {}, {}, {}],
            [
              { text: vm.$t('externalUser.trade_dispute_current_fiscal_year'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.trade_dispute_current_fiscal_year) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [
              { text: vm.$t('externalUser.dispute_settled'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: parseInt(vm.application.other_compliance.dispute_settled) === 1 ? (vm.currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (vm.currentLocale === 'en' ? 'No' : 'না'), style: 'td' }
            ],
            [
              { text: vm.$t('externalUser.other_info_if_any'), bold: true, style: 'td', colSpan: '3' },
              {},
              {},
              { text: vm.application.other_compliance.other_information, style: 'td' }
            ],
            [
              { text: vm.$t('externalUser.applicant_signature'), bold: true, style: 'td', colSpan: '2' },
              {},
              { image: 'data:image/png;base64,' + vm.application.other_compliance.pdfSignature.data, height: 50, width: 80, colSpan: '2' },
              {}
            ]
          ]
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: '25%',
              body: Compliance2
            },
            layout: {
              hLineWidth: function (i, node) {
                return 0
              },
              vLineWidth: function (i, node) {
                return 0
              }
            }
          })
        }

        const waterMarkText = i18n.locale === 'bn' ? 'বাণিজ্য মন্ত্রণালয়' : 'Ministry of Commerce'
        var docDefinition = {
          content: pdfContent,
          pageSize: 'A4',
          pageOrientation: 'portrait',
          watermark: { text: waterMarkText, color: 'blue', opacity: 0.1, bold: true, italics: false },
          styles: {
            th: {
              fillColor: '#dee2e6',
              fontSize: 10,
              margin: [3, 2, 3, 2]
            },
            mytd: {
              fillColor: '#dee2e6',
              fontSize: 11,
              margin: [0, 1, 0, 1],
              alignment: 'center'
            },
            td: {
              fontSize: 10,
              margin: [3, 2, 3, 2]
            },
            identity: {
              margin: [0, 5, 0, 3],
              fontSize: 12,
              alignment: 'center'
            },
            left_header: {
              margin: [4, 0, 0, 10]
            },
            header: {
              margin: [0, 10, 0, 10],
              fontSize: 14,
              alignment: 'center'
            },
            header2: {
              border: 0,
              fontSize: 14,
              margin: [0, 0, 0, 1]
            },
            title_header: {
              margin: [0, 10, 0, 0],
              fontSize: 14,
              alignment: 'center'
            },
            my_title: {
              border: 0,
              fillColor: '#dee2e6',
              fontSize: 13,
              margin: [0, 10, 0, 10],
              bold: true,
              alignment: 'center'
            },
            govt_info: {
              margin: [0, 1, 0, 1],
              fontSize: 15,
              alignment: 'center'
            },
            address: {
                border: 0,
                fontSize: 10,
                bold: true,
                margin: [0, 0, 0, 1]
            },
            address2: {
              border: 0,
              fontSize: 12,
              bold: true,
              margin: [0, 0, 0, 1]
            },
            left_logo: {
              border: 0,
              margin: [5, 0, 0, 5]
            }
          }
        }
        pdfMake.createPdf(docDefinition, null, null, null).print() // 'et-application')
    } catch (error) {
      if (error) {}
    }
    Store.commit('mutateCommonProperties', {
      loading: false
    })
}
export default {
  exportPdfDetails
}
