const cipAppTypeList = [
    {
        value: 1,
        text_en: 'Single',
        text_bn: 'একক'
    },
    {
        value: 2,
        text_en: 'Group',
        text_bn: 'গ্রুপ'
    }
]
const latentExporterList = [
    {
        value: 1,
        text_en: 'Yes',
        text_bn: 'হ্যাঁ'
    },
    {
        value: 2,
        text_en: 'No',
        text_bn: 'না'
    },
    {
        value: 3,
        text_en: 'Partial',
        text_bn: 'আংশিক'
    }
]
const orgTypeList = [
    {
        value: 1,
        text_en: 'Private Ltd',
        text_bn: 'প্রাইভেট লিমিটেড'
    },
    {
        value: 2,
        text_en: 'Public Ltd',
        text_bn: 'পাবলিক লিমিটেড'
    },
    {
        value: 3,
        text_en: 'Privately Owned',
        text_bn: 'ব্যক্তিগত মালিকানাধীন'
    }
]
const merchandisingTypeList = [
    {
        value: 1,
        text_en: 'Textile Factory',
        text_bn: 'টেক্সটাইল ফ্যাক্টরি'
    },
    {
        value: 2,
        text_en: 'Others',
        text_bn: 'অন্যান্য'
    }
]
const paymentTypeList = [
    {
        value: 1,
        text_en: 'Registration Fee',
        text_bn: 'আবেদন ফি',
        amount: 5000,
        step_id: 0
    },
    {
        value: 2,
        text_en: 'Security Money',
        text_bn: 'নিরাপত্তার ফি',
        amount: 30000,
        step_id: 4
    },
    {
        value: 3,
        text_en: 'License',
        text_bn: 'লাইসেন্স ফি',
        amount: 10000,
        step_id: 4
    },
    {
        value: 4,
        text_en: 'Renewal Fee',
        text_bn: 'নবায়ন ফি',
        amount: 10000,
        step_id: 0
    },
    {
        value: 5,
        text_en: 'Late Fee',
        text_bn: 'বিলম্ব ফি',
        amount: 1000,
        step_id: 0
    }
]
export default {
    cipAppTypeList,
    latentExporterList,
    orgTypeList,
    merchandisingTypeList,
    paymentTypeList
}
