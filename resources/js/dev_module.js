import {DateTime} from 'luxon'


const devModule = {
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
    }
}

export default devModule