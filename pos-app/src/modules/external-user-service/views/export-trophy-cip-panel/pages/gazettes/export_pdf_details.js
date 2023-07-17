import i18n from '@/i18n'
import Store from '@/store'
import ReportHeading from '@/utils/report-head'
import pdfMake from 'pdfmake/build/pdfmake'
import pdfFontsBn from 'pdfmake/build/vfs_fonts_bn'
import pdfFontsEn from 'pdfmake/build/vfs_fonts_en'
// import { dateFormat, mobileNumber } from '@/utils/fliter'

const exportPdfDetails = async (baseUrl, uri, orgId, reportTitle, vm) => {
    function getTitle () {
      return i18n.locale === 'bn' ? vm.form.title_bn : vm.form.title_en
    }
    function getDesignation (item) {
      return i18n.locale === 'en' ? item.org_info.designation_en : item.org_info.designation_bn
    }
    function getOrgnation (item) {
      return i18n.locale === 'en' ? item.org_info.org_name_en : item.org_info.org_name_bn
    }
    function getTradeName (item) {
      return i18n.locale === 'en' ? item.name_en : item.name_bn
    }
    function getFbcciDesignation (item) {
      return i18n.locale === 'en' ? item.fbcci_designation_en + ', FBCCI' : item.fbcci_designation_bn + ', এফবিসিসিআই'
    }
    function getAssociation (item) {
      return i18n.locale === 'en' ? 'Representative ,' + item.referred_association_en : 'প্রতিনিধি ,' + item.referred_association_bn
    }
    function getOrgName (item) {
      return i18n.locale === 'en' ? item.org_info.org_name_en : item.org_info.org_name_bn
    }
    function getTrophyName (trophy) {
      if (parseInt(trophy) === 1) {
        return vm.$t('exportTrophyConfig.gold')
      }
      if (parseInt(trophy) === 2) {
        return vm.$t('exportTrophyConfig.silver')
      }
      if (parseInt(trophy) === 3) {
        return vm.$t('exportTrophyConfig.bronze')
      }
    }
    try {
      Store.commit('mutateCommonProperties', {
        loading: true
      })
      if (i18n.locale === 'bn') {
        pdfMake.vfs = pdfFontsBn.pdfMake.vfs
      } else {
        pdfMake.vfs = pdfFontsEn.pdfMake.vfs
      }
      const reportHeadData = await ReportHeading.getReportHead(baseUrl, uri, orgId)

        const pdfContent = [
          { text: vm.$t('exportTrophyGazette.registered_no'), style: 'org', alignment: 'left' },
          { text: vm.$t('exportTrophyGazette.slogan'), style: 'org', alignment: 'center' }
        ]
        pdfContent.push({ text: '', style: 'fertilizer' })
        const allRows = [
          [
            { text: vm.$t('exportTrophyGazette.country'), style: 'header', alignment: 'right', bold: true },
            { image: reportHeadData.reportHeadColumn[1].image, height: 70, width: 70, alignment: 'center' },
            { text: vm.$t('exportTrophyGazette.gazette'), style: 'header', alignment: 'left', bold: true }
          ],
          [
            {},
            { text: vm.$t('exportTrophyGazette.extra'), style: 'td', alignment: 'center', bold: true },
            {}
          ],
          [
            {},
            { text: vm.$t('exportTrophyGazette.procasona'), style: 'td', alignment: 'center', bold: true },
            {}
          ]
        ]
        pdfContent.push({
          table: {
            headerRows: 1,
            widths: ['40%', '20%', '40%'],
            body: allRows
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
        pdfContent.push({ text: '', style: 'fertilizer' })
        pdfContent.push({ text: '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t', style: ['fullLineBorder', 'background1'] })
        pdfContent.push({ text: vm.getDayName + ', ' + vm.getDateLocals, style: 'td', alignment: 'center', bold: true })
        pdfContent.push({ text: '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t', style: ['fullLineBorder', 'background1'] })
        pdfContent.push({ text: vm.$t('exportTrophyGazette.govt_name'), style: 'subHeaderFont', alignment: 'center' })
        pdfContent.push({ text: vm.$t('exportTrophyGazette.ministry_name'), style: 'subHeaderFont', alignment: 'center' })
        pdfContent.push({ text: vm.$t('exportTrophyGazette.sub_section_name'), style: 'subHeaderFont', alignment: 'center' })

        const rows = [
          [
            { text: vm.$t('exportTrophyCircular.memo_no') + ' : ' + vm.EngBangNum(vm.form.memo_no), style: 'tdCustom3', alignment: 'left', rowSpan: 2 },
            { text: vm.$t('globalTrans.date') + ':', style: 'tdCustom3', alignment: 'right', rowSpan: 2 },
            { text: vm.getBnDateLocals, style: 'tdCustom', alignment: 'left', decoration: 'underline', lineHeight: 2 }
          ],
          [
            {},
            {},
            { text: vm.getDateLocals, style: 'tdCustom2', alignment: 'center', lineHeight: 0.5 }
          ]
        ]
        pdfContent.push({
          table: {
            headerRows: 1,
            widths: ['70%', '10%', '20%'],
            body: rows
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

        pdfContent.push({ text: vm.$t('exportTrophyGazette.notification'), style: 'subHeaderFont', alignment: 'center', bold: true })
        if (vm.form.type === 1) {
          pdfContent.push({ text: vm.getBnDateLocals + '/' + vm.getDateLocals, style: 'subHeaderFont', alignment: 'center' })
        }
        if (vm.form.type === 2) {
          pdfContent.push({ text: vm.$t('exportTrophyGazette.national_export_tropy') + ' : ' + vm.getFiscalYear(vm.form.fiscal_year_id), style: 'exportTropyUnder', alignment: 'center', decoration: 'underline' })
        }
        if (vm.form.type === 1) {
          pdfContent.push({ text: vm.EngBangNum(vm.form.memo_no) + ' ' + getTitle(), style: 'td', alignment: 'left' })
          pdfContent.push({ text: vm.$t('exportTrophyGazette.cip_product_export') + ': ' + vm.EngBangNum(vm.cipApps.length), style: 'td', alignment: 'left' })
        }
        if (vm.form.type === 2) {
          pdfContent.push({ text: vm.getFiscalYear(vm.form.fiscal_year_id) + ' ' + getTitle(), style: 'td', alignment: 'left' })
        }

        if (vm.form.type === 1) {
          const allRowsHead = [
            [
              { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'left' },
              { text: vm.$t('exportTrophyGazette.name_designation_org_address'), style: 'th', alignment: 'left' },
              { text: vm.$t('exportTrophyGazette.sector'), style: 'th', alignment: 'left' }
            ]
          ]
          vm.cipApps.forEach((item, index) => {
            allRowsHead.push([
              { text: vm.$n(index + 1), style: 'td', alignment: 'left' },
              { text: vm.getName(item.user_id) + '\n' + getDesignation(item) + ' \n' + getOrgnation(item) + '\n' + vm.getAddress(item.org_address), style: 'td', alignment: 'left' },
              { text: vm.getProductName(item.product_service_sector_id), style: 'td', alignment: 'left' }
            ])
          })
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: ['10%', '60%', '30%'],
              body: allRowsHead
            }
          })

          pdfContent.push({ text: vm.$t('exportTrophyGazette.cip_trade') + ': ' + vm.EngBangNum(vm.cipTrades.length), style: 'td', alignment: 'left' })

          const allTrade = [
            [
              { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'left' },
              { text: vm.$t('exportTrophyGazette.name_designation_org'), style: 'th', alignment: 'left' }
            ]
          ]
          vm.cipTrades.forEach((item, index) => {
            allTrade.push([
              { text: vm.$n(index + 1), style: 'td', alignment: 'left' },
              { text: getTradeName(item) + ' \n ' + getFbcciDesignation(item) + ' \n ' + getAssociation(item), style: 'td', alignment: 'left' }
            ])
          })
          pdfContent.push({
            table: {
              headerRows: 1,
              widths: ['10%', '90%'],
              body: allTrade
            }
          })
        }

        if (vm.form.type === 2) {
          let dataCount = 1
          for (const prop in vm.etApps) {
            pdfContent.push({ text: '(' + dataCount++ + ') ' + vm.$t('exportTrophyGazette.product_sector') + ': ' + vm.getProductName(parseInt(prop)), style: 'td', alignment: 'left' })
            const allRowsHead = [
              [
                { text: vm.$t('globalTrans.sl_no'), style: 'th', alignment: 'left' },
                { text: vm.$t('exportTrophyGazette.trophy_receive_org_name'), style: 'th', alignment: 'left' },
                { text: vm.$t('exportTrophyGazette.trophy_cat'), style: 'th', alignment: 'left' }
              ]
            ]
            vm.etApps[prop].forEach((item, index2) => {
              allRowsHead.push([
                { text: vm.$n(parseInt(index2) + 1), style: 'td', alignment: 'left' },
                { text: getOrgName(item) + '\n' + vm.getAddress(item.org_address), style: 'td', alignment: 'left' },
                { text: getTrophyName(item.trophy), style: 'td', alignment: 'left' }
              ])
            })
            pdfContent.push({
              table: {
                headerRows: 1,
                widths: ['10%', '60%', '30%'],
                body: allRowsHead
              }
            })
          }
        }
        const waterMarkText = i18n.locale === 'bn' ? 'বাণিজ্য মন্ত্রণালয়' : 'Ministry of Commerce'
        var docDefinition = {
        content: pdfContent,
        pageSize: 'A4',
        pageOrientation: 'portrait',
        watermark: { text: waterMarkText, color: 'blue', opacity: 0.1, bold: true, italics: false },
        styles: {
          th: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            margin: [3, 3, 3, 3]
          },
          td: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            margin: [3, 3, 3, 3]
          },
          tdCustom: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            padding: [0, 0, 0, 10]
          },
          tdCustom2: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            margin: [25, -10, 0, 0]
          },
          tdCustom3: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            margin: [0, 9, 0, 0]
          },
          search: {
            fontSize: (i18n.locale === 'bn') ? 10 : 11,
            margin: [3, 3, 3, 3]
          },
          fertilizer: {
            margin: [5, 0, 0, 5]
          },
          header: {
              fontSize: 30,
              bold: true,
              margin: [0, 20, 0, 0]
          },
          org: {
              fontSize: 13,
              bold: true,
              margin: [0, -25, 10, 5]
          },
          address: {
              fontSize: 11,
              margin: [0, 0, 0, 5]
          },
          hh: {
              fontSize: 13,
              bold: true,
              margin: [10, 10, 25, 20]
          },
          header2: {
            fontSize: 14,
            margin: [0, 10, 0, 20]
          },
          headerPort1: {
            fontSize: 10,
            margin: [0, 20, 0, 5]
          },
          headerPort: {
            fontSize: 10,
            margin: [0, 4, 0, 15]
          },
          krishi: {
            margin: [0, -5, 0, 15],
            alignment: 'center'
          },
          header3: {
            fontSize: 9,
            margin: [0, 0, 0, 0]
          },
          tableSubHead: {
            margin: [0, 5, 0, 15]
          },
          background1: {
            background: '#333'
          },
          fullLineBorder: {
            fontSize: 2,
            alignment: 'center',
            color: 'white'
          },
          subHeaderFont: {
            fontSize: 16
          },
          exportTropyUnder: {
            fontSize: 16
          }
        }
      }
      pdfMake.createPdf(docDefinition, null, null, null).print()
      vm.customloading = false
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
