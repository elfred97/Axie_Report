<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-4">
                <type-component :type="form.type_id" @updateType="form.type_id = $event"></type-component>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Subject</label>
                <input type="text" class="form-control" placeholder="Subject" v-model="form.title">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Message</label>
                <textarea name="" id="" cols="20" rows="4" class="form-control" v-model="form.description" placeholder="Message Here"></textarea>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <label for="">Date and Time</label>
                <v-datepicker v-model="form.reminder_time" type="datetime" valueType="format"  format="YYYY-MM-DD HH:mm:ss"></v-datepicker>
            </div>
            <div class="col-md-4">
                <label for="">Repeat</label>
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    v-model="form.recurrence"
                    >
                        <option :value="index" v-for="(recurrence, index) in recurrences">{{ recurrence }}</option>
                </select> 
            </div>
            <div class="col-md-4">
                <label for="">Repeat</label>
                <select 
                    name="data-table-default_length" 
                    aria-controls="data-table-default" 
                    class="custom-select custom-select-sm form-control form-control-sm"
                    v-model="form.status"
                    >
                        <option value="0">Active</option>
                        <option value="1">Inactive</option>
                </select> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-xs pull-right" @click="saveReminder()">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['reminder'],
    data(){
        return {
            form : new Form({
                id : 0,
                type_id   : null,
                title: null,
                description: null,
                reminder_time : null,
                recurrence : 0,
                status : 0,
            }),
            recurrences : [
                'Never',
                'Monthly', 
                'Weekly', 
                'Daily',
            ],

        }
    },
    watch : {
        reminder : {
            handler(newVal){
                this.form.reminder_time = moment(newVal.reminder_time).format('YYYY-MM-DD HH:mm:ss');
            }
        }
    },
    methods : {
        saveReminder(){
            let url = '';
            if(this.reminder)
                url = 'updateReminder/'+this.form.id;
            else
                url = 'newReminder';
            this.form.post(url)
            .then((response) => {
               this.$root.$emit('isClose', true);
               this.$noty.success("Reminder Saved");
               this.$events.fire('update_reminders_table');
            })
            .catch((error) => {
                // this.form.errors = error.response.data.errors;
                console.log(error);
            })
        },
        resetForm(){
            this.form = new Form({
                id           : 0,
                type_id      : null,
                title        : null,
                description  : null,
                reminder_time: null,
                recurrence   : 0,
                status       : 0,
            })

        }
    },
    mounted(){
        if(this.reminder){
            this.reminder.reminder_time = moment(this.reminder.reminder_time).format('YYYY-MM-DD HH:mm:ss');
            this.form = new Form(this.reminder);
        }
        else {
            this.resetForm();
        }
    }
}
</script>