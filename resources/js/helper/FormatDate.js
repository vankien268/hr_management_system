import moment from 'moment';
export const helperDate = {
    formatDateDDMMYYYY: (value)=> {
        if(value) {
            return  moment(String(value)).format('DD-MM-YYYY');
        }
    }
} 