import i18n from '@/i18n'
import Store from '@/store'
import ReportHeading from '@/utils/report-head'
import pdfMake from 'pdfmake/build/pdfmake'
import pdfFontsBn from 'pdfmake/build/vfs_fonts_bn'
import pdfFontsEn from 'pdfmake/build/vfs_fonts_en'

const exportPdfDetails = async (baseUrl, uri, orgId, reportTitle, vm, data, date, meetingDate) => {
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
      const pdfContent = [{
            columns: reportHeadData.reportHeadColumn
        },
        { text: reportHeadData.orgName, style: 'org', alignment: 'center' },
        { text: reportHeadData.projectName, style: 'address', alignment: 'center' },
        { text: reportHeadData.address, style: 'address', alignment: 'center' },
        { text: reportTitle, style: 'hh', alignment: 'center' }
    ]
        pdfContent.push({ text: '', style: 'fertilizer' })
        pdfContent.push({ text: 'No. - BFTI/Admin (Monthly Meeting)/2021                                                   Date- ' + date, style: 'fertilizer' })
        pdfContent.push({ text: '', style: 'fertilizer' })
        pdfContent.push({ text: data[0].meeting_title_en, style: 'fertilizer', alignment: 'center' })
        pdfContent.push({ text: data[0].venue_en, style: 'fertilizer', alignment: 'center' })
        pdfContent.push({ text: meetingDate, style: 'fertilizer', alignment: 'center' })
        pdfContent.push({ text: '', style: 'fertilizer' })
        pdfContent.push({ text: data[0].agenda_text_en, style: 'fertilizer' })
        // const currentLocale = vm.currentLocale
        const allRows = [
          [
            { text: vm.$t('systemActivityManage.item'), style: 'th', alignment: 'left', bold: true },
            { text: vm.$t('systemActivityManage.decision'), style: 'th', bold: true },
            { text: vm.$t('systemActivityManage.update'), style: 'th', alignment: 'left', bold: true },
            { text: vm.$t('globalTrans.designation'), style: 'th', alignment: 'left', bold: true },
            { text: vm.$t('stakeholder.employee_name'), style: 'th', alignment: 'left', bold: true }
          ]
        ]
        data[0].heads.forEach((head, index) => {
          head.details.forEach((detail, index1) => {
            allRows.push(
            [
              { text: detail.item, style: 'td', alignment: 'left', bold: true },
              { text: detail.decision, style: 'td', alignment: 'left', bold: true },
              { text: detail.update, style: 'td', alignment: 'left', bold: true },
              { text: detail.item, style: 'td', alignment: 'left', bold: true },
              { text: detail.item, style: 'td', alignment: 'left', bold: true }
            ]
            )
          })
        })
        pdfContent.push({
          table: {
            headerRows: 1,
            widths: ['20%', '30%', '20%', '15%', '15%'],
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
        // const waterMarkText = i18n.locale === 'bn' ? 'বাণিজ্য মন্ত্রণালয়' : 'Ministry of Commerce'
        var docDefinition = {
        content: pdfContent,
        pageSize: 'A4',
        pageOrientation: 'portrait',
        // watermark: { text: waterMarkText, color: 'blue', opacity: 0.1, bold: true, italics: false },
        styles: {
          th: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            margin: [3, 3, 3, 3]
          },
          td: {
            fontSize: (i18n.locale === 'bn') ? 9 : 8,
            margin: [3, 3, 3, 3]
          },
          search: {
            fontSize: (i18n.locale === 'bn') ? 10 : 11,
            margin: [3, 3, 3, 3]
          },
          fertilizer: {
            margin: [5, 0, 0, 5]
          },
          header: {
              fontSize: 16,
              bold: true,
              margin: [0, 0, 0, 0]
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
          }
        }
      }
      pdfMake.createPdf(docDefinition, null, null, null).print()
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
