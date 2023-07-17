<template>
    <div class="inner-section">
        <b-row v-if="dataLoad">
            <b-col xs="12" sm="12" md="12" class="text-right mb-2">
                <b-button @click="pdfExport()" class="btn-sm" variant="primary">{{  $t('globalTrans.export_pdf') }}</b-button>
            </b-col>
        </b-row>
        <body-card>
            <template v-slot:body>
                <b-col v-if="!dataLoad" md="12">
                    <div class="text-center">
                        <p>{{ (currentLocale === 'en') ? 'Loading! Please wait...' : 'লোড হচ্ছে! অনুগ্রহপূর্বক অপেক্ষা করুন...' }}</p>
                        <div class="spinner-grow text-info" role="status"></div>
                    </div>
                </b-col>
                <b-col v-else md="12">
                    <!-- Tab-1: Basic Information  -->
                    <b-row class="mb-3">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('globalTrans.basic_information') }}</h5>
                        </div>
                    </b-row>
                    <b-row>
                        <b-col lg="12" sm="12">
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('exportTrophyCircular.circular') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'bn' ? application.circular.title_bn : application.circular.title_en }}</b-td>
                                        <b-th width="20%">{{ $t('exportTrophyCircular.memo_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.circular.memo_no }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.export_product_sector') }}</b-th>
                                        <b-td class="text-left">{{ productName(application.product_service_sector_id) }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.cip_application_type') }}</b-th>
                                        <b-td class="text-left">{{ getAppType(application.app_type) }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.latent_exporter') }}</b-th>
                                        <b-td class="text-left" colspan="3">{{ getLatentExporter(application.latent_exporter) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.cip_applicants') + ' ' + $t('globalTrans.information') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.cip_applicants') + ' ' + $t('globalTrans.name') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'bn' ? application.name_bn : application.name_en }}</b-td>
                                        <b-th width="20%">{{ $t('globalTrans.father_name') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'bn' ? application.father_name_bn : application.father_name_en }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('globalTrans.mother_name') }}</b-th>
                                        <b-td class="text-left">{{ currentLocale === 'bn' ? application.mother_name_bn : application.mother_name_en }}</b-td>
                                        <b-th>{{ $t('globalTrans.gender') }}</b-th>
                                        <b-td class="text-left">{{ genderName(application.gender) }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('globalTrans.dob') }}</b-th>
                                        <b-td class="text-left">{{ application.dob | dateFormat }}</b-td>
                                        <b-th>{{ $t('globalTrans.nid') }}</b-th>
                                        <b-td class="text-left">{{ $n(application.nid, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.cip_applicants') + ' ' + $t('externalUser.passport') + ' ' + $t('globalTrans.information') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.passport_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.passport_info.passport_no }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.issuing_country') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ countryName(application.passport_info.country_id) }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.issue_date') }}</b-th>
                                        <b-td class="text-left">{{ application.passport_info.issue_date | dateFormat }}</b-td>
                                        <b-th>{{ $t('externalUser.duration') }}</b-th>
                                        <b-td class="text-left">{{ $n(application.passport_info.duration, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.cip_applicants') + ' ' + $t('externalUser.tax') + ' ' + $t('globalTrans.information') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.tin_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ $n(application.tax_info.tin_no, { useGrouping: false }) }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.tax_circle') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.tax_info.tax_circle }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.tax_region') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ currentLocale === 'bn' ? application.tax_info.tax_region_bn : application.tax_info.tax_region_en }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.cip_applicants') + ' ' + $t('externalUser.contact') + ' ' + $t('globalTrans.information') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.telephone_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ $n(application.contact_info.telephone_no, { useGrouping: false }) }}</b-td>
                                        <b-th width="20%">{{ $t('globalTrans.mobile') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.contact_info.mobile_no | mobileNumber }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.email') }}</b-th>
                                        <b-td class="text-left">{{ application.contact_info.email }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.fax_no') }}</b-th>
                                        <b-td class="text-left">{{ $n(application.contact_info.fax_no, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                    <!-- Tab-2: Address  -->
                    <b-row v-if="application.address !== null">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('externalUser.cip_applicants') + ' ' + $t('globalTrans.address') }}</h5>
                        </div>
                        <b-col lg="12" sm="12" class="mt-3">
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.present_address') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ AddressHelper.getPresentAddress(application.address) }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.permanent_address') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ AddressHelper.getPermanentAddress(application.address) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                    <!-- Tab-3: Organization Info  -->
                    <b-row v-if="application.org_info !== null">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('externalUser.org_info') }}</h5>
                        </div>
                        <b-col lg="12" sm="12" class="mt-3">
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.owner_name') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'bn' ? application.org_info.owner_name_bn : application.org_info.owner_name_en }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.org_name') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'bn' ? application.org_info.org_name_bn : application.org_info.org_name_en }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('globalTrans.designation') }}</b-th>
                                        <b-td class="text-left">{{ currentLocale === 'bn' ? application.org_info.designation_bn : application.org_info.designation_en }}</b-td>
                                        <b-th>{{ $t('externalUser.bin_no') }}</b-th>
                                        <b-td class="text-left">{{ $n(application.org_info.bin_no, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.org_type') }}</b-th>
                                        <b-td class="text-left">{{ orgTypeName(application.org_info.org_type) }}</b-td>
                                        <b-th>{{ $t('externalUser.epz_affiliated_org') }}</b-th>
                                        <b-td class="text-left">{{ parseInt(application.org_info.epz_affiliated_org) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.bangladeshi_owned_compnay') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ parseInt(application.org_info.bangladeshi_owned_company) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.org_address') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ AddressHelper.getPresentAddress(org_address) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="Object.values(application.org_tax_info).length > 0" striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.org_tax_info') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.tin_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ $n(application.org_tax_info.tin_no, { useGrouping: false }) }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.tax_circle') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.org_tax_info.tax_circle }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th>{{ $t('externalUser.tax_region') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ currentLocale === 'bn' ? application.org_tax_info.tax_region_bn : application.org_tax_info.tax_region_en }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="Object.values(application.office_contact_info).length > 0" striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.office_contact_info') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.telephone_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ $n(application.office_contact_info.telephone_no, { useGrouping: false }) }}</b-td>
                                        <b-th width="20%">{{ $t('globalTrans.mobile') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.office_contact_info.mobile_no | mobileNumber }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.email') }}</b-th>
                                        <b-td class="text-left">{{ application.office_contact_info.email }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.fax_no') }}</b-th>
                                        <b-td class="text-left">{{ $n(application.office_contact_info.fax_no, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="Object.values(application.factory_contact_info).length > 0" striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.factory_contact_info') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('externalUser.telephone_no') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ $n(application.factory_contact_info.telephone_no, { useGrouping: false }) }}</b-td>
                                        <b-th width="20%">{{ $t('globalTrans.mobile') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ application.factory_contact_info.mobile_no | mobileNumber }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.email') }}</b-th>
                                        <b-td class="text-left">{{ application.factory_contact_info.email }}</b-td>
                                        <b-th width="20%">{{ $t('externalUser.fax_no') }}</b-th>
                                        <b-td class="text-left">{{ $n(application.factory_contact_info.fax_no, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="Object.values(application.contact_person_info).length > 0" striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.contact_person_info') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.name') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'en' ? application.contact_person_info.name_en : application.contact_person_info.name_bn }}</b-td>
                                        <b-th width="20%">{{ $t('globalTrans.designation') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ currentLocale === 'bn' ? application.contact_person_info.designation_bn : application.contact_person_info.designation_en }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="20%">{{ $t('globalTrans.mobile') }}</b-th>
                                        <b-td colspan="3" class="text-left">{{ application.contact_person_info.mobile | mobileNumber }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                    <!-- Tab-4: Group Based Info  -->
                    <b-row v-if="application.group_based_app.length > 0">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('externalUser.group_based') + ' ' + $t('globalTrans.information') }}</h5>
                        </div>
                        <b-col lg="12" sm="12" class="mt-3">
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="3" width="70%">{{ $t('externalUser.applied_group_of_companies') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ parseInt(application.applied_group_of_companies) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="application.group_based_app.length > 0 && parseInt(application.applied_group_of_companies) === 1" bordered>
                                <thead>
                                    <b-tr>
                                        <b-th colspan="6"><h6 class="text-center text-info">{{ $t('externalUser.group_based_application_data') }}</h6></b-th>
                                    </b-tr>
                                    <tr class="text-white bg-primary">
                                        <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.group_name') }}</th>
                                        <th scope="col">{{ $t('externalUser.group_org_name') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_value') }}</th>
                                        <th scope="col">{{ $t('globalTrans.attachment') }}</th>
                                    </tr>
                                </thead>
                                <b-tbody>
                                    <b-tr v-for="(item, index) in application.group_based_app" :key="index">
                                        <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                        <b-td>{{ currentLocale === 'bn' ? item.group_name_bn : item.group_name_en }}</b-td>
                                        <b-td>{{ currentLocale === 'bn' ? item.org_name_bn : item.org_name_en }}</b-td>
                                        <b-td>{{ $n(item.export_value, { useGrouping: false }) }}</b-td>
                                        <b-td>
                                            <span v-for="(document, indx) in item.attachments" :key="indx">
                                                <a v-if="document.attachment" class="btn btn-success btn-sm rounded-pill mr-1" target="_blank" :href="baseUrl + 'download-attachment?file=' + document.attachment" title="attachment"><i class="ri-download-cloud-fill"></i></a>
                                            </span>
                                        </b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                    <!-- Tab-5: Bank Based Info  -->
                    <b-row v-if="application.bank.length > 0">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('externalUser.bank_list') }}</h5>
                        </div>
                        <b-col lg="12" sm="12" class="mt-3">
                            <b-table-simple bordered>
                                <thead class="text-white bg-primary">
                                    <tr>
                                        <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.bank_name') }}</th>
                                        <th scope="col">{{ $t('externalUser.branch_name') }}</th>
                                        <th scope="col">{{ $t('globalTrans.address') }}</th>
                                    </tr>
                                </thead>
                                <b-tbody>
                                    <b-tr v-for="(item, index) in application.bank" :key="index">
                                        <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                        <b-td>{{ currentLocale === 'bn' ? item.bank_name_bn : item.bank_name_en }}</b-td>
                                        <b-td>{{ currentLocale === 'bn' ? item.branch_name_bn : item.branch_name_en }}</b-td>
                                        <b-td>{{ currentLocale === 'bn' ? item.address_bn : item.address_en }}</b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                    <!-- Tab-6: Product Description  -->
                    <b-row v-if="application.product_success_description.length > 0">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('externalUser.export_product_and_success') }}</h5>
                        </div>
                        <b-col lg="12" sm="12" class="mt-3">
                            <b-table-simple bordered>
                                <thead class="text-white bg-primary">
                                    <tr>
                                        <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_product_name') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_destinations') }}</th>
                                        <th scope="col">{{ $t('globalTrans.year') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_volume') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_value_usd') }}</th>
                                        <th scope="col">{{ $t('externalUser.income_growth') }}</th>
                                    </tr>
                                </thead>
                                <b-tbody>
                                    <b-tr v-for="(item, index) in application.product_success_description" :key="index">
                                        <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                        <b-td>{{ productName(item.product_id) }}</b-td>
                                        <b-td>
                                            <div v-for="(itm, indx) in item.destination_id" :key="indx">
                                                {{ destinationName(parseInt(itm)) }}
                                            </div>
                                        </b-td>
                                        <b-td>{{ $n(item.year, { useGrouping: false }) }}</b-td>
                                        <b-td>{{ $n(item.export_volume, { useGrouping: false }) }}</b-td>
                                        <b-td>{{ $n(item.export_value_ssd, { useGrouping: false }) }}</b-td>
                                        <b-td>{{ $n(item.income_growth, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                    <!-- Tab-7: Others Compliance Info  -->
                    <b-row v-if="application.other_compliance !== null">
                        <div class="bg-primary w-50 m-auto rounded-pill">
                            <h5 class="text-white text-center py-1"> {{ $t('externalUser.compliance_information') }}</h5>
                        </div>
                        <b-col lg="12" sm="12" class="mt-3">
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th width="35%">{{ $t('externalUser.export_leather_shoes') }}</b-th>
                                        <b-td width="15%" class="text-left">{{ parseInt(application.other_compliance.export_leather_shoes) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                        <b-th width="35%">{{ $t('externalUser.merchandising_prc') }}</b-th>
                                        <b-td width="15%" class="text-left">
                                            <a v-if="application.other_compliance.merchandising_prc" class="btn btn-success btn-sm rounded-pill" target="_blank" :href="baseUrl + 'download-attachment?file=' + application.other_compliance.merchandising_prc" title="attachment"><i class="ri-download-cloud-fill"></i></a>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th colspan="4"><h6 class="text-center text-info">{{ $t('externalUser.org_compliance_information') }}</h6></b-th>
                                    </b-tr>
                                    <b-tr>
                                        <b-th colspan="3" width="70%">{{ $t('externalUser.compliance_current_fiscal_year') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ parseInt(application.other_compliance.compliance_current_fiscal_year) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="35%">{{ $t('externalUser.merchandising_sector') }}</b-th>
                                        <b-td width="15%" class="text-left">{{ merchandisingSectorName(application.other_compliance.merchandising_sector) }}</b-td>
                                        <b-th width="35%">
                                            {{ application.other_compliance.merchandising_sector == 1 ? $t('externalUser.textile_factory_inspection') : $t('externalUser.updated_inspection') }}
                                        </b-th>
                                        <b-td width="15%" class="text-left">
                                            <a v-if="application.other_compliance.report" class="btn btn-success btn-sm rounded-pill" target="_blank" :href="baseUrl + 'download-attachment?file=' + application.other_compliance.report" title="attachment"><i class="ri-download-cloud-fill"></i></a>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th colspan="3" width="70%">{{ $t('externalUser.export_destination_add') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ parseInt(application.other_compliance.export_destination_add) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <!-- Destination add  -->
                            <b-table-simple v-if="parseInt(application.other_compliance.export_destination_add) === 1" bordered>
                                <thead class="text-white bg-primary">
                                    <tr>
                                        <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                        <th scope="col">{{ $t('globalTrans.country') }}</th>
                                        <th scope="col">{{ $t('externalUser.prc_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.buyer_org_name') }}</th>
                                        <th scope="col">{{ $t('externalUser.prc_date') }}</th>
                                        <th scope="col">{{ $t('externalUser.realization_date') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_value_usd') }}</th>
                                    </tr>
                                </thead>
                                <b-tbody>
                                    <b-tr v-for="(item, index) in application.export_destination" :key="index">
                                        <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                        <b-td>{{ countryName(item.country_id) }}</b-td>
                                        <b-td>{{ $n(item.prc_no, { useGrouping: false }) }}</b-td>
                                        <b-td>{{ currentLocale === 'en' ? item.buyer_org_name_en : item.buyer_org_name_bn }}</b-td>
                                        <b-td>{{ item.prc_date | dateFormat }}</b-td>
                                        <b-td>{{ item.realization_date | dateFormat }}</b-td>
                                        <b-td>{{ $n(item.export_value_usd, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                            <!-- Export Product Add -->
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="3" width="70%">{{ $t('externalUser.export_products_add') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ parseInt(application.other_compliance.export_products_add) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="parseInt(application.other_compliance.export_products_add) === 1" bordered>
                                <thead class="text-white bg-primary">
                                    <tr>
                                        <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.product_name') }}</th>
                                        <th scope="col">{{ $t('externalUser.prc_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.hs_code') }}</th>
                                        <th scope="col">{{ $t('externalUser.prc_date') }}</th>
                                        <th scope="col">{{ $t('externalUser.realization_date') }}</th>
                                        <th scope="col">{{ $t('externalUser.export_value_usd') }}</th>
                                    </tr>
                                </thead>
                                <b-tbody>
                                    <b-tr v-for="(item, index) in application.export_product" :key="index">
                                        <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                        <b-td>{{ productName(item.product_id) }}</b-td>
                                        <b-td>{{ $n(item.prc_no, { useGrouping: false }) }}</b-td>
                                        <b-td>{{ item.hs_code }}</b-td>
                                        <b-td>{{ item.prc_date | dateFormat }}</b-td>
                                        <b-td>{{ item.realization_date | dateFormat }}</b-td>
                                        <b-td>{{ $n(item.export_value_usd, { useGrouping: false }) }}</b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                            <!-- Selected Year  -->
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th colspan="3" width="70%">{{ $t('externalUser.applicant_selected_cip_past_year') }}</b-th>
                                        <b-td width="30%" class="text-left">{{ parseInt(application.other_compliance.applicant_selected_cip_past_year) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                            <b-table-simple v-if="parseInt(application.other_compliance.applicant_selected_cip_past_year) === 1" bordered>
                                <thead class="text-white bg-primary">
                                    <tr>
                                        <th class="text-center" width="100px">{{ $t('globalTrans.sl_no') }}</th>
                                        <th scope="col">{{ $t('externalUser.selection_year') }}</th>
                                        <th scope="col">{{ $t('externalUser.product_name') }}</th>
                                    </tr>
                                </thead>
                                <b-tbody>
                                    <b-tr v-for="(item, index) in application.cip_selected" :key="index">
                                        <b-td class="text-center">{{ $n(index + 1) }}</b-td>
                                        <b-td>{{ $n(item.selection_year, { useGrouping: false }) }}</b-td>
                                        <b-td>{{ productName(item.product_sector_id) }}</b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                             <!-- Note  -->
                            <b-row v-if="application.note !== null">
                                <div class="bg-primary w-50 m-auto rounded-pill">
                                    <h5 class="text-white text-center"> {{ $t('cip.primary_sorting_note') }}</h5>
                                </div>
                                <b-col lg="12" sm="12" class="mt-3">
                                    {{ application.note }}
                                </b-col>
                            </b-row>
                            <!-- MOC Scrutiny approve note  -->
                            <b-row v-if="application.moc_scrutiny_approve_note !== null">
                                <div class="bg-primary w-50 m-auto rounded-pill">
                                    <h5 class="text-white text-center"> {{ $t('cip.moc_scrutiny_approve_note') }}</h5>
                                </div>
                                <b-col lg="12" sm="12" class="mt-3">
                                    {{ application.moc_scrutiny_approve_note }}
                                </b-col>
                            </b-row>
                            <!-- MOC Committee approve note  -->
                            <b-row v-if="application.moc_committee_approve_note !== null">
                                <div class="bg-primary w-50 m-auto rounded-pill">
                                    <h5 class="text-white text-center"> {{ $t('cip.moc_committee_approve_note') }}</h5>
                                </div>
                                <b-col lg="12" sm="12" class="mt-3">
                                    {{ application.moc_committee_approve_note }}
                                </b-col>
                            </b-row>
                            <b-table-simple striped small>
                                <tbody>
                                    <b-tr>
                                        <b-th width="35%">{{ $t('externalUser.trade_dispute_current_fiscal_year') }}</b-th>
                                        <b-td width="15%" class="text-left">{{ parseInt(application.other_compliance.trade_dispute_current_fiscal_year) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                        <b-th width="35%">{{ $t('externalUser.dispute_settled') }}</b-th>
                                        <b-td width="15%" class="text-left">{{ parseInt(application.other_compliance.dispute_settled) === 1 ? (currentLocale === 'en' ? 'Yes' : 'হ্যাঁ') : (currentLocale === 'en' ? 'No' : 'না') }}</b-td>
                                    </b-tr>
                                    <b-tr v-if="parseInt(application.other_compliance.dispute_settled) === 1">
                                        <b-th colspan="3" width="70%">{{ $t('externalUser.dispute_settled_document') }}</b-th>
                                        <b-td width="30%" class="text-left">
                                            <a v-if="application.other_compliance.dispute_settled_document" class="btn btn-success btn-sm rounded-pill" target="_blank" :href="baseUrl + 'download-attachment?file=' + application.other_compliance.dispute_settled_document" title="attachment"><i class="ri-download-cloud-fill"></i></a>
                                        </b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th width="30%">{{ $t('externalUser.other_info_if_any') }}</b-th>
                                        <b-td colspan="3" width="70%" class="text-left">{{ application.other_compliance.other_information }}</b-td>
                                    </b-tr>
                                    <b-tr>
                                        <b-th  width="30%">{{ $t('externalUser.applicant_signature') }}</b-th>
                                        <b-td colspan="3" class="text-left">
                                            <!-- <a v-if="application.other_compliance.signature" class="btn btn-success btn-sm rounded-pill" target="_blank" :href="baseUrl + 'download-attachment?file=storage/' + application.other_compliance.signature" title="attachment"><i class="ri-download-cloud-fill"></i></a> -->
                                            <img v-if="application.other_compliance.signature" width="50%" height="80px" :src="baseUrl + 'download-attachment?file=storage/' + application.other_compliance.signature"/>
                                        </b-td>
                                    </b-tr>
                                </tbody>
                            </b-table-simple>
                        </b-col>
                    </b-row>
                </b-col>
            </template>
        </body-card>
        <b-row class="text-right">
          <b-col>
            <b-button variant="danger" class="btn-sm mt-2" @click="$bvModal.hide('modal-detail')">{{ $t('globalTrans.cancel') }}</b-button>
          </b-col>
        </b-row>
    </div>
</template>
<script>
import RestApi, { exportTrophyCIPServiceBaseUrl } from '@/config/api_config'
import { cipApplicationDetailsApi } from '../../api/routes'
import { mapGetters } from 'vuex'
import AddressHelper from '@/utils/area-type-address'
import ExportPdf from './export-pdf'

export default {
    props: ['id'],
    data () {
        return {
            AddressHelper: AddressHelper,
            baseUrl: exportTrophyCIPServiceBaseUrl,
            dataLoad: false,
            application: {},
            org_address: {}
        }
    },
    created () {
        if (this.id) {
            this.getCipData()
        }
    },
    watch: {
    },
    computed: {
        ...mapGetters({
            commonProfile: 'Auth/commonProfile',
            authUser: 'Auth/authUser'
        }),
        currentLocale () {
            return this.$i18n.locale
        }
    },
    methods: {
        merchandisingSectorName (Id) {
          const Obj = this.$store.state.ExternalUserService.cipPanel.merchandisingTypeList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
            return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        productName (Id) {
          const Obj = this.$store.state.ExternalUserService.cipPanel.commonObj.exportSectorList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
            return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        destinationName (Id) {
          const Obj = this.$store.state.CommonService.commonObj.countryList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
              return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        fiscalYearName (Id) {
          const Obj = this.$store.state.CommonService.commonObj.fiscalYearList.find(item => item.value === Id)
          if (typeof Obj !== 'undefined') {
            return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
          } else {
            return ''
          }
        },
        orgTypeName (Id) {
            const Obj = this.$store.state.ExternalUserService.cipPanel.orgTypeList.find(el => el.value === Id)
            if (typeof Obj !== 'undefined') {
                return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
            } else {
                return ''
            }
        },
        countryName (Id) {
            const Obj = this.$store.state.CommonService.commonObj.countryList.find(el => el.value === Id)
            if (typeof Obj !== 'undefined') {
                return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
            } else {
                return ''
            }
        },
        genderName (Id) {
            const Obj = this.$store.state.commonObj.genderList.find(el => el.value === Id)
            if (typeof Obj !== 'undefined') {
                return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
            } else {
                return ''
            }
        },
        getLatentExporter (Id) {
            const Obj = this.$store.state.ExternalUserService.cipPanel.latentExporterList.find(el => el.value === Id)
            if (typeof Obj !== 'undefined') {
                return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
            } else {
                return ''
            }
        },
        getAppType (Id) {
            const Obj = this.$store.state.ExternalUserService.cipPanel.cipAppTypeList.find(el => el.value === Id)
            if (typeof Obj !== 'undefined') {
                return this.$i18n.locale === 'bn' ? Obj.text_bn : Obj.text_en
            } else {
                return ''
            }
        },
        async getCipData () {
            const result = await RestApi.getData(exportTrophyCIPServiceBaseUrl, cipApplicationDetailsApi, { app_id: this.id })
            if (result.success) {
                this.application = result.data
                if (result.data.org_address !== null) {
                    this.org_address = {
                        pr_area_type_id: this.application.org_address.area_type_id,
                        pr_division_id: this.application.org_address.division_id,
                        pr_district_id: this.application.org_address.district_id,
                        pr_upazila_id: this.application.org_address.upazila_id,
                        pr_city_corporation_id: this.application.org_address.city_corporation_id,
                        pr_union_id: this.application.org_address.union_id,
                        pr_ward_id: this.application.org_address.ward_id,
                        pr_pauroshoba_id: this.application.org_address.paurashava_id
                    }
                }
                this.dataLoad = true
            } else {
                this.dataLoad = false
            }
        },
        pdfExport () {
            const reportTitle = this.$t('externalUser.cip_application') + ' ' + this.$t('globalTrans.details')
            ExportPdf.exportPdfDetails(reportTitle, this)
            // ExportPdf.exportPdfDetails(exportTrophyCIPServiceBaseUrl, 'configuration/report-heading/detail', 2, reportTitle, myData, this)
        }
    }
}
</script>
