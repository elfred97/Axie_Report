<template>
    <div>
        <div class="section-container">
            <div class="container">
                <div class="vertical-box-row">
                    <!-- begin vertical-box-cell -->
                    <div class="vertical-box-cell">
                        <!-- begin vertical-box-inner-cell -->
                        <div class="vertical-box-inner-cell bg-white">
                            <!-- begin scrollbar -->
                            <div class="slimScrollDiv inbox" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                                <div data-scrollbar="true" data-height="100%" data-init="true" style="overflow: hidden; width: auto; height: 100%;">
                                    <!-- begin list-email -->
                                    <ul class="list-group list-group-lg no-radius list-email">
                                        <li class="list-group-item unread">
                                            <div class="email-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox1">
                                                    <label class="custom-control-label" for="emailCheckbox1"></label>
                                                </div>
                                            </div>
                                            <a href="email_detail.html" class="email-user bg-blue">
                                                <span class="text-white">F</span>
                                            </a>
                                            <div class="email-info">
                                                <a href="email_detail.html">
                                                    <span class="email-sender">Facebook Blueprint</span>
                                                    <span class="email-title">Newly released courses, holiday marketing tips, how-to video, and more!</span>
                                                    <span class="email-desc">Sed scelerisque dui lacus, quis pellentesque lorem tincidunt rhoncus. Nulla accumsan elit pharetra, lacinia turpis nec, varius erat.</span>
                                                    <span class="email-time">Today</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="list-group-item unread">
                                            <div class="email-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox2">
                                                    <label class="custom-control-label" for="emailCheckbox2"></label>
                                                </div>
                                            </div>
                                            <a href="email_detail.html" class="email-user bg-indigo">
                                                <span class="text-white">C</span>
                                            </a>
                                            <div class="email-info">
                                                <a href="email_detail.html">
                                                    <span class="email-sender">Color Admin</span>
                                                    <span class="email-title">Color Admin dashboard v2 is ready for live</span>
                                                    <span class="email-desc">Proin interdum aliquam urna, quis lobortis magna tincidunt ac. Integer sed pulvinar neque...</span>
                                                    <span class="email-time">Today</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="list-group-item unread">
                                            <div class="email-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox3">
                                                    <label class="custom-control-label" for="emailCheckbox3"></label>
                                                </div>
                                            </div>
                                            <a href="email_detail.html" class="email-user bg-grey">
                                                <span class="text-white">W</span>
                                            </a>
                                            <div class="email-info">
                                                <a href="email_detail.html">
                                                    <span class="email-sender">support@wrapbootstrap.com</span>
                                                    <span class="email-title">Bootstrap v4.0 is coming soon</span>
                                                    <span class="email-desc">Praesent id pulvinar orci. Donec ac metus non ligula faucibus venenatis. Suspendisse tortor est, placerat eu dui sed...</span>
                                                    <span class="email-time">Today</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="email-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox4">
                                                    <label class="custom-control-label" for="emailCheckbox4"></label>
                                                </div>
                                            </div>
                                            <a href="email_detail.html" class="email-user bg-grey">
                                                <i class="fab fa-github-alt text-white"></i>
                                            </a>
                                            <div class="email-info">
                                                <a href="email_detail.html">
                                                    <span class="email-sender">Github</span>
                                                    <span class="email-title">Sidebar animation bugfix</span>
                                                    <span class="email-desc">Nam sit amet lacinia massa, sit amet blandit urna. Duis pharetra ex id ipsum posuere...</span>
                                                    <span class="email-time">2 days ago</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="email-checkbox">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" data-checked="email-checkbox" id="emailCheckbox5">
                                                    <label class="custom-control-label" for="emailCheckbox5"></label>
                                                </div>
                                            </div>
                                            <a href="email_detail.html" class="email-user bg-grey">
                                                <span class="text-white">W</span>
                                            </a>
                                            <div class="email-info">
                                                <a href="email_detail.html">
                                                    <span class="email-sender">Wrapbootstrap</span>
                                                    <span class="email-title">Bootstrap Framework is awesome</span>
                                                    <span class="email-desc">Etiam enim ipsum, malesuada in consectetur interdum, malesuada et lacus. Aenean faucibus turpis lorem...</span>
                                                    <span class="email-time">1 week ago</span>
                                                </a>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                    <!-- end list-email -->
                                </div>
                            </div>
                            <!-- end scrollbar -->
                        </div>
                        <!-- end vertical-box-inner-cell -->
                    </div>
                    <!-- end vertical-box-cell -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {    
    data() {
        return {
            
        }
    }
}
</script>