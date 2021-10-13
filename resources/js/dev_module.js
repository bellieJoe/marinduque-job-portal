import {DateTime} from 'luxon'


const devModule = {

    // data
    specializations: [
        'Accountancy, banking and finance',
        'Business, consulting and management',
        'Charity and voluntary work',
        'Creative arts and design',
        'Energy and utilities',
        'Engineering and manufacturing',
        'Environment and agriculture',
        'Healthcare',
        'Hospitality and events management',
        'Information and Technology',
        'Law',
        'Law enforcement and security',
        'Leisure, sports and tourism',
        'Marketing, advertising and PR',
        'Media and internet',
        'Property and construction',
        'Public services and administration',
        'Recruitment and HR',
        'Retail',
        'Sales',
        'Science and pharmaceuticals',
        'Social care',
        'Teacher training and education',
        'Transport and logisctics',
        'Entertainment'

    ],

    course : [
        'Bachelor of Science in Accountancy',
        'Bachelor of Science in Management Accounting',
        'Bachelor of Science in Business Administration Major in Financial Management',
        'Bachelor of Science in Architecture',
        'Bachelor of Science and Interior Design',
        'Bachelor of Arts in English Language Studies',
        'Bachelor of Arts in Filipino',
        'Bachelor of Arts Literary and Cultural Studies',
        'Bachelor of Arts in Philosophy',
        'Bachelor of Performing Arts Major in Theater Arts',
        'Bachelor of Science and Business Administration Major in Human Resource Management',
        'Bachelor of Science in Business Administration Major in Marketing Management',
        'Bachelor of Enterpreneurship',
        'Bachelor of Science Office Administration',
        'Bachelor in Advertising and Public Relations',
        'Bachelor of Arts in Broadcasting',
        'Bachelor of Arts in Communication Research',
        'Bachelor of Arts in Journalism',
        'Bachelor of Science in Computer Science',
        'Bachelor of Science in Information Technology',
        'Bachelor in Elementary Education',
        'Bachelor in Library and Information Science',
        'Bachelor of Secondary Education Major in English',
        'Bachelor of Secondary Education Major in Filipino',
        'Bachelor of Secondary Education Major in Mathematics',
        'Bachelor of Secondary Education Major in Science',
        'Bachelor of Secondary Education Major in Social Studies',
        'Bachelor of Science in Civil Engineering',
        'Bachelor of Science in Computer Engineering',
        'Bachelor of Science in Electrical Engineering',
        'Bachelor of Science in Electronics Engineering',
        'Bachelor of Science in Industrial Engineering',
        'Bachelor of Science in Mechanical Engineering',
        'Bachelor of Physcial Education',
        'Bachelor of Science in Exercises and Sports',
        'Bachelor of Public Administration',
        'Bachelor of Arts in International Studies',
        'Bachelor of Arts in Political Economy',
        'Bachelor of Arts in Political Science',
        'Bachelor of Science in Economics',
        'Bachelor of Science in Psychology',
        'Bachelor of Science Food Technology',
        'Bachelor of Science in Applied Mathematics',
        'Bachelor of Science in Biology',
        'Bachelor of Science in Chemistry',
        'Bachelor of Science in Mathematics',
        'Bachelor of Science in Nutrition and Dietetics',
        'Bachelor of Science in Physics',
        'Bachelor of Science in Statistics',
        'Bachelor of Science in Hospitality Management',
        'Bachelor of Science in Tourism Management',
        'Bachelor of Science in Transportation Management',

        
    ],

    masters : [
        'Master of Arts',
        'Master of Science',
        'Master of Research',
        'Master of Studies',
        'Master of Business Administration',
        'Master of Library Science',
        'Master of Public Administration',
        'Master of Public Health',
        'Master of Social Work',
        'Master of Arts in Liberal Studies',
        'Master of Fine Arts',
        'Master of Music',
        'Master of Education',
        'Master of Engineering',
        'Master of Architecture',
    ],

    doctors : [
        'PhD in Educational Administration',
        'PhD in Education',
        'PhD in Philosophy',
        'PhD in Pscychology',
        'PhD in Science Education',
        'PhD in Science Education',
        'PhD in Biology',
        'PhD in Computer Science',
        'PhD in Mathematics',
        'PhD in Electronics Engineering',
        'PhD in Chemistry',
        'PhD in Chemical Engineering',
        'PhD in Business Management',
        'PhD in Development Administration',
        'PhD in Agricultural Sciences',
        'PhD in Communication',
    ],


    // methods
    diffForHumans: ( date )=>{
        let startDateTime = DateTime.fromISO(date)
        let currentDateTime = DateTime.now()

        let diff = currentDateTime.diff(startDateTime, ['seconds','minutes', 'hours', 'days','weeks', 'months','years']);

        if(diff.years != 0){
            if(diff.years > 1){

                return `${diff.years} years ago`

            }else if (diff.months != 0){

                return `${diff.years} year and ${ diff.months } months ago`
                
            }else{
                
                return `${diff.years} year ago`

            }
        }else if(diff.months != 0){

            return diff.months == 1 ? `${diff.months} month ago` : `${diff.months} months ago`

        }else if (diff.weeks != 0){

            return diff.weeks == 1 ? `${diff.weeks} week ago` : `${diff.weeks} weeks ago`

        }else if (diff.days != 0){
            
            return diff.days == 1 ? `${diff.days} day ago` : `${diff.days} days ago`

        }else if (diff.hours != 0){

            return diff.hours == 1 ? `${diff.hours} hour ago` : `${diff.hours} hours ago`

        }else if (diff.minutes != 0){

            return diff.minutes == 1 ? `${diff.minutes} minute ago` : `${diff.minutes} minutes ago`

        }else{

            return diff.seconds == 1 ? `${diff.seconds} second ago` : `${diff.seconds} seconds ago`

        }
        
        console.log(diff.years)
    },

    defineSalaryGrade(s){

        if(s >= 12034 && s < 12790){

            return 1;

        }else if(s >= 12790 && s < 13572){

            return 2;

        }else if(s >= 13572 && s < 14400){

            return 3;

        }else if(s >= 14400 && s < 15275){

            return 4;

        }else if(s >= 15275 && s < 16200){

            return 5;

        }else if(s >= 16200 && s < 17179){

            return 6;

        }else if(s >= 17179 && s < 18251){

            return 7;

        }else if(s >= 18251 && s < 19593){

            return 8;

        }else if(s >= 19593 && s < 21205){

            return 9;

        }else if(s >= 21205 && s < 23877){

            return 10;

        }else if(s >= 23877 && s < 26052){

            return 11;

        }else if(s >= 26052 && s < 28276){

            return 12;

        }else if(s >= 28276 && s < 30799){

            return 13;

        }else if(s >= 30799 && s < 33575){

            return 14;

        }else if(s >= 33575 && s < 36628){

            return 15;

        }else if(s >= 36628 && s < 39986){

            return 16;

        }else if(s >= 39986 && s < 43681){

            return 17;

        }else if(s >= 43681 && s < 48313){

            return 18;

        }else if(s >= 48313 && s < 54251){

            return 19;

        }else if(s >= 54251 && s < 60901){

            return 20;

        }else if(s >= 60901 && s < 68415){

            return 21;

        }else if(s >= 68415 && s < 76907){

            return 22;

        }else if(s >= 76907 && s < 86742){

            return 23;

        }else if(s >= 86742 && s < 98886){

            return 24;

        }else if(s >= 98886 && s < 111742){

            return 25;

        }else if(s >= 111742 && s < 126267){

            return 26;

        }else if(s >= 126267 && s < 142683){

            return 27;

        }else if(s >= 142683 && s < 161231){

            return 28;

        }else if(s >= 161231 && s < 182191){

            return 29;

        }else if(s >= 182191 && s < 268121){

            return 30;

        }else if(s >= 268121 && s < 319660){

            return 31;

        }else if(s >= 319660 && s < 403620){

            return 32;

        }else if(s >= 403620){

            return 33;
        }else{}

    }
}

export default devModule