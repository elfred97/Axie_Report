<template>
    <div>
        <div v-if="scholarData.qr_code">
            <h4 class="mb-2 mt-2 text-center">Scan QR Code</h4>
            <img :src="getQRCode"  class="img-fluid"/> 

            <p class="text-center mt-2">QR Code is valid for 7 days</p>
        </div>
        <div v-else class="no_qr_code">
            <img src="img/no_qr.jpg" alt="" class="img-fluid">
            <p class="text-center">No QR Code uploaded</p>
        </div>
    </div>
</template>
<script>
export default {
    props: ['scholarData'],
    computed : {
        getQRCode: function (){
            return '/uploads/' + this.scholarData.qr_code;
        }
    },
}
</script>