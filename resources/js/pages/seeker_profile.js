import $ from 'jquery'
import phil from 'phil-reg-prov-mun-brgy'
import moment from 'moment'
import nationality_list from 'npm-nationality-list'
import LanguageList from 'language-list'
import devModule from '../dev_module.js'

// const language = new LanguageList()
// console.log(language.getData())

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});



const loading = $("#loading")
loading.css('display', 'none')
const mdlAddEducation = new bootstrap.Modal(document.getElementById("mdlAddEducationForm"))

new Vue({
    el: '#SeekerProfile',
    data: {
        user: null,
        errors: [],
        educationLevelError: null,
        job_industries: devModule.specializations,
        courses: devModule.course,
        masters: devModule.masters,
        doctors: devModule.doctors,

        // education data
        undergraduate: 0,
        eduToDelete: null,
        eduToUpdate: null,
        education: {
            education_level: null,
            school_name: null,
            school_address: null,
            course: null,
            year_graduated: null,
        },

        // experience data
        expToUpdate: null,
        expToDelete: null,
        experience: {
            job_title: null,
            job_industry: null,
            company_name: null,
            job_description: null,
            date_started: null,
            date_ended: null,
            salary: null,
            salary_grade: null,
            status_of_appointment: null,
            govnt_service: true
        },

        // personal information
        nationality: nationality_list.getList(),
        profile: {
            firstname: null,
            middlename: null,
            lastname: null,
            gender: null,
            nationality: null,
            civil_status: null,
            birthdate: null,
            contact_number: null,
            address: null
        },

        // language data
        languages: new LanguageList().getData(),
        languageList: [],
        language: null,

        // skill data
        skillToEdit: null,
        skillToDelete: null,
        skills: {
            skill: []
        },

        // credentials data
        crdtlToUpdate: null,
        crdtlToDelete: null,
        credential: {
            credential_type: null,
            credential_name: null,
            issuing_organisation: null,
            credential_number: null,
            date_issued: null,
            expiry_date: null,
            non_expiry: false,
            credential_image: null
        }


    },
    methods: {

        closeEducationLevelError(){
            this.educationLevelError = null
        },

        closeLoading() {
            // setTimeout(() => {
            //     loading.css('display', 'none')
            // }, 3000);
            loading.css('display', 'none')
        },

        // credential methods
        clearCredential() {
            this.errors = []
            this.credential = {
                credential_type: null,
                credential_name: null,
                issuing_organisation: null,
                credential_number: null,
                date_issued: null,
                expiry_date: null,
                non_expiry: false,
                credential_image: null
            }
        },

        setCredentialImage() {
            console.log(event.target.files[0])
            
            if (event.target.files[0]) {
                var fileReader = new FileReader()
                fileReader.readAsDataURL(event.target.files[0])

                fileReader.addEventListener('load', (ev) => {
                    this.credential.credential_image = ev.target.result.split(",")[1]
                    console.log(this.credential_image)
                })
            } else {
                window.alert("Image failed to set")
                this.credential.credential_image = this.credential.credential_image
            }

        },

        async addCredential() {
            try {
                loading.css('display', 'initial')
                console.log(this.credential)

                this.errors = []
                await $.ajax({
                    url: '/seeker/profile/certificate/add-credential',
                    data: this.credential,
                    method: 'post',
                })

                location.href = location.href
            } catch (error) {
                console.log(error)
            }

        },

        changeCredentialType(type) {
            if (type == "award") {
                this.credential.non_expiry = true
            }
            this.credential.credential_type = type
        },

        showEditCredential(id) {
            this.clearCredential()
            $.ajax({
                url: `/seeker/profile/certificate/get-credential/${id}`,
                method: "post",
            }).fail((res) => {
                // console.log(res)
                // location.href = "/error"
            }).done((res) => {
                // console.log(res)
                this.crdtlToUpdate = res.credential_id
                this.credential = {
                    credential_type: res.credential_type,
                    credential_name: res.credential_name,
                    issuing_organisation: res.issuing_organization,
                    credential_number: res.credential_number,
                    date_issued: moment(res.date_issued).format('YYYY-MM-DD'),
                    expiry_date: res.expiry_date ? moment(res.expiry_date).format('YYYY-MM-DD') : null,
                    non_expiry: res.non_expiry,
                    credential_image: res.credential_image
                }
            })
        },

        updateCredential() {
            loading.css('display', 'initial')
            console.log(this.credential)
            $.ajax({
                url: `/seeker/profile/certificate/update-credential/${this.crdtlToUpdate}`,
                method: "post",
                data: this.credential,
                statusCode: {
                    500: () => {
                        // location.href = "/error"
                    }
                }
            }).fail((res) => {
                console.log(res)
                loading.css('display', 'none')
                this.errors = res.responseJSON.errors
            }).done(() => {
                location.href = location.href
            })
        },

        deleteCredential(id, confirmed) {

            if (confirmed) {
                loading.css('display', 'initial')
                $.ajax({
                    url: `/seeker/profile/certificate/delete-credential/${this.crdtlToDelete}`,
                    method: "post"
                }).fail((res) => {
                    // location.href = "/error"
                    loading.css('display', 'none')
                    console.log(res)
                }).done(() => {
                    location.href = location.href
                })
            } else {

                this.crdtlToDelete = id
            }
            console.log("delete")
        },

        // eps
        toggleView: function (name) {
            location.href = `/seeker/profile/${name}`
        },

        // education methods
        toggleUndergraduate: function () {
            if (this.undergraduate == 1) {
                this.education.year_graduated = "0000"
            } else {
                this.education.year_graduated = null
            }
        },

        showAddEducationForm: function () {
            this.errors = []
            this.undergraduate = 0
            this.education = {
                education_level: null,
                school_name: null,
                school_address: null,
                course: null,
                year_graduated: null,
            }
        },

        showEditEducationForm: function (id) {
            this.eduToUpdate = id
            this.errors = []
            this.undergraduate = 0
            $.ajax({
                url: `/seeker/profile/get-education/${id}`,
                method: "get"
            }).fail(() => {
                // location.href = "/error"
            }).done((res) => {
                console.log(res)
                if (res.year_graduated == '0000') {
                    this.undergraduate = 1
                }
                this.education = {
                    education_level: res.education_level,
                    school_name: res.school_name,
                    school_address: res.school_address,
                    course: res.course,
                    year_graduated: res.year_graduated,
                }
            })
        },

        addNewEducation: async function () {
            loading.css('display', 'initial')
            console.log(this.education)
            try {
                const education = await $.ajax({
                    url: "/seeker/profile/add-education",
                    method: "post",
                    data: this.education,
                    
                })

                if(JSON.parse(education).educationLevelError){
                    this.educationLevelError = JSON.parse(education).educationLevelError
                    this.closeLoading()
                    // this.closeAddEducationForm()
                }else{
                    location.href = "/seeker/profile/education"
                }

                

            } catch (error) {
                console.log(error)
                this.errors = error.responseJSON.errors ? error.responseJSON.errors : null 
                this.closeLoading()
                // window.alert('Something went wrong while uploading the data')
            }

        },

        deleteEducation: function (id, confirmed) {
            if (id && !confirmed) {
                this.eduToDelete = id
            } else if (confirmed && !id) {
                console.log(`Delete educ id ${this.eduToDelete}`)
                loading.css('display', 'initial')
                $.ajax({
                    url: `/seeker/profile/delete-education/${this.eduToDelete}`,
                    method: "get",
                    statusCode: {
                        500: () => {
                            // location.href = "/error"
                        }
                    },
                }).fail(() => {
                    console.log("Error Deleting record")
                    loading.css('display', 'none')
                    // location.href = "/error"
                }).done(() => {
                    location.href = "/seeker/profile/education"
                })
            } else if (!confirmed && !id) {
                this.eduToDelete = null
                console.log(`Cancel delete educ id ${this.eduToDelete}`)
            }
        },

        updateEducation: function () {
            loading.css('display', 'initial')
            $.ajax({
                url: `/seeker/profile/update-education/${this.eduToUpdate}`,
                method: "post",
                data: this.education
            }).fail(() => {
                loading.css('display', 'none')
                // location.href = "/error"
            }).done(() => {
                location.href = "/seeker/profile/education"
            })
        },

        // experience methods
        setGovntService(){
            this.experience.govnt_service = $('#add_govnt_service')[0].checked
        },
        setSalaryGrade(){
            this.experience.salary_grade = this.experience.salary ? devModule.defineSalaryGrade(this.experience.salary) : null
        },

        showAddExperienceForm: function () {
            this.errors = []
            this.experience = {
                job_title: null,
                job_industry: null,
                company_name: null,
                job_description: null,
                date_started: null,
                date_ended: null,
                salary: null,
                salary_grade: null,
                status_of_appointment: null,
                govnt_service: null
            }
        },

        showEditExperience(id) {
            this.errors = []
            this.expToUpdate = id
            $.ajax({
                url: `/seeker/profile/experience/get-experience/${id}`,
                method: "get",
            }).fail((res) => {
                console.log(res)
            }).done((res) => {
                this.experience = {
                    job_title: res.job_title,
                    job_industry: res.job_industry,
                    company_name: res.company_name,
                    job_description: res.job_description,
                    date_started: moment(res.date_started).format('YYYY-MM-DD'),
                    date_ended: moment(res.date_ended).format('YYYY-MM-DD'),
                    salary: res.salary,
                    salary_grade: res.salary_grade,
                    status_of_appointment: res.status_of_appointment,
                    govnt_service: res.govnt_service
                }
            })

        },

        async addExperience() {
            this.setGovntService()
            this.errors = []
            try {

                loading.css('display', 'initial')
                await $.ajax({
                    url: `/seeker/profile/experience/add-experience`,
                    method: "post",
                    data: this.experience,
                })

                location.href = "/seeker/profile/experience"
                console.log(this.experience)

            } catch (error) {

                console.log(error)
                loading.css('display', 'none')
                this.errors = error.responseJSON.errors

            }
            
        },

        updateExperience() {
            this.errors = []
            loading.css('display', 'initial')
            $.ajax({
                url: `/seeker/profile/experience/update-experience/${this.expToUpdate}`,
                method: "post",
                data: this.experience,
                statusCode: {
                    500: () => {
                        // location.href  = "/error"
                    }
                }
            }).fail((res) => {
                console.log(res)
                loading.css('display', 'none')
                this.errors = res.responseJSON.errors
            }).done(() => {
                location.href = "/seeker/profile/experience"
            })
        },

        deleteExperience(id, confirmed) {
            if (id && !confirmed) {
                this.expToDelete = id
            } else if (confirmed && !id) {
                // console.log(`Delete educ id ${this.expToDelete}`)
                loading.css('display', 'initial')
                $.ajax({
                    url: `/seeker/profile/experience/delete-experience/${this.expToDelete}`,
                    method: "get",
                    statusCode: {
                        500: () => {
                            // location.href = "/error"
                        }
                    },
                }).fail((res) => {
                    console.log("Error Deleting record")
                    loading.css('display', 'none')
                    // location.href = "/error"
                }).done(() => {
                    location.href = "/seeker/profile/experience"
                })
            } else if (!confirmed && !id) {
                this.expToDelete = null
                // console.log(`Cancel delete educ id ${this.eduToDelete}`)
            }
        },

        // personal information methods
        showUpdateProfile(id) {
            this.errors = []
            $.ajax({
                url: `/seeker/profile/personal/get-profile`,
                method: "get",

            }).fail((res) => {
                console.log(res)
            }).done((res) => {
                this.profile = {
                    firstname: res.firstname,
                    middlename: res.middlename,
                    lastname: res.lastname,
                    gender: res.gender,
                    nationality: res.nationality,
                    civil_status: res.civil_status,
                    birthdate: res.birthdate ? moment(res.birthdate).format('YYYY-MM-DD') : null,
                    contact_number: res.contact_number,
                    address: res.address
                }
            })
        },

        updateProfile() {
            this.errors = []
            loading.css('display', 'initial')
            $.ajax({
                url: `/seeker/profile/personal/update-profile`,
                data: this.profile,
                method: "post",
                statusCode: {
                    500: () => {
                        // location.href = "/error"
                    }
                }
            }).fail((res) => {
                loading.css('display', 'none')
                // console.log(res.responseJSON)
                this.errors = res.responseJSON.errors
            }).done(() => {
                // console.log("oki gumanasai")
                location.href = "/seeker/profile/personal"
            })
        },

        // languge methods
        addLanguage() {
            let cont = true
            this.errors = []
            console.log(this.languageList)
            if (this.languageList != null) {
                this.languageList.map((val, i) => {
                    if (val == this.language) {
                        cont = false
                    }
                })
            } else {
                cont = true
            }

            if (cont) {

                $('#btnShowLoading').trigger('click')
                loading.css('display', 'initial')
                $.ajax({
                    url: '/seeker/profile/language/add-language',
                    method: 'post',
                    data: { language: this.language },
                    statusCode: {
                        500: () => {
                            // location.href = "/error"
                        }
                    }
                }).fail((res) => {
                    loading.css('display', 'none')
                    this.errors = res.responseJSON.errors
                    // $('#btnCloseLoading').trigger('click')
                }).done(() => {
                    this.getLanguage()
                    this.language = null
                    // $('#btnCloseLoading').trigger('click')
                })
            } else {
                $('#btnShowDuplicateLanguageAlert').trigger('click')
                this.language = null
            }

        },

        async getLanguage() {
            try {
                await $.ajax({
                    url: '/seeker/profile/language/get-language',
                    method: 'post',
                }).done((res) => {
                    this.languageList = JSON.parse(res.language)
                    // console.log(this.languageList)
                })
                loading.css('display', 'none')
            } catch (error) {
                console.log(error)
            }

        },

        deleteLanguage(lang) {
            loading.css('display', 'initial')
            $.ajax({
                url: `/seeker/profile/language/delete-language/${lang}`,
                method: 'post',
            }).fail((res) => {
                loading.css('display', 'none')
                // location.href = "/error"
            }).done(() => {
                loading.css('display', 'none')
                this.getLanguage()
            })
        },

        // skill methods
        showEditSkill(id) {
            console.log(id)
            this.errors = []
            this.skillToEdit = id
            $.ajax({
                url: `/seeker/profile/skill/get-skill/${this.skillToEdit}`,
                method: 'post',

            }).fail((res) => {
                // console.log(res)
                // location.href = "/error"
            }).done((res) => {
                // console.log(res)
                this.skills = {
                    skill: res.skill_description
                }
            })
        },

        async getSkill(){

        
        },

        async addSkill() {
            this.errors = []
            loading.css('display', 'initial')
            console.log(this.skills)
            
            try {
                
                let res = await $.ajax({
                    url: '/seeker/profile/skill/add-skill',
                    method: 'post',
                    data: this.skills,
                    
                })

               location.href = location.href

                
            } catch (error) {
                console.log(error)
                
                this.errors = error.responseJSON.errors
            }

            loading.css('display', 'none')
        },

        updateSkill() {
            loading.css('display', 'initial')
            $.ajax({
                url: `/seeker/profile/skill/update-skill/${this.skillToEdit}`,
                method: 'post',
                data: this.skills,
                statusCode: {
                    500: () => {
                        // location.href = "/error"
                    }
                }
            }).fail((res) => {
                console.log(res)
                loading.css('display', 'none')
                this.errors = res.responseJSON.errors
            }).done(() => {
                location.href = location.href
            })
        },

        deleteSkill(id, confirmed) {
            if (id && !confirmed) {
                this.skillToDelete = id
            } else if (confirmed && !id) {
                // console.log(`Delete educ id ${this.expToDelete}`)
                loading.css('display', 'initial')
                $.ajax({
                    url: `/seeker/profile/skill/delete-skill/${this.skillToDelete}`,
                    method: "post",
                    statusCode: {
                        500: () => {
                            // location.href = "/error"
                        }
                    },
                }).fail(() => {
                    console.log("Error Deleting record")
                    // location.href = "/error"
                }).done(() => {
                    location.href = location.href
                })
            } else if (!confirmed && !id) {
                this.skillToDelete = null
                // console.log(`Cancel delete educ id ${this.eduToDelete}`)
            }
        },

        redirectRoute(route){
            location.href = route
        }

    },

    created() {

        $.ajax({
            url: '/get-auth',
            method: 'get'
        }).fail(() => {
            // location.href = "/error"
        }).done((res) => {
            this.user = res
            if ($('#bdgLanguage').css('display') == 'none') {
                $('#bdgLanguage').css('display', 'initial')
            } else {

            }
            // console.log(this.user)
        })
        this.getLanguage()

    },

})