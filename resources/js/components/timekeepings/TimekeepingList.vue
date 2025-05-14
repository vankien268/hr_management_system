<template>
    <div class="col-xxl-12 col-xl-12">
        <!--begin::Tables Widget 9-->
        <div class="card card-xxl-stretch pt-5">
                <div class="content d-flex flex-column " id="kt_content">
                    <!--begin::Container-->
                    <div class="container-xxl" id="kt_content_container">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <h2 class="card-title fw-bold">Lịch chấm công</h2>
                                <div class="card-toolbar">
                                    <button v-if="! isComplete" class="btn btn-flex btn-primary" @click="updateTimekeeping()" data-kt-calendar="add">
                                       {{! isCheckIn ? 'Chấm công vào' : 'Chấm công ra' }}</button>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Calendar-->
                                <div id="kt_calendar_app"></div>
                                <!--end::Calendar-->
                            </div>
                            <!--end::Card body-->
                        </div>

                        <!--begin::Modal - New Product-->
                        <div class="modal fade" id="kt_modal_view_event" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <!--begin::Modal content-->

                            </div>
                        </div>
                        <!--end::Modal - New Product-->
                        <!--end::Modals-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
</template>

<script setup>
    import {onMounted, reactive, ref, watch} from 'vue';
    import axios from "axios";
    import {useToast} from "../../helper/toastMessage";

    const rawData = [
        {
            start_time: "12:36",
            end_time: "12:36",
            date: "2025-05-14"
        }

    ];

    const formTimekeeping = reactive({
        start_time: null,
        end_time: null,
        checkin_date : null
    });

    const isCheckIn = ref(false);
    const isComplete = ref(false);


    const A = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();

    const events = ref([]);

    const getInfoTimekeeping = (params = null) => {
        KTApp.showPageLoading();
        return axios({
            url: "/timekeepings/get-info",
            method: "GET",
            params: params,
        })
            .then((res) => {
                isCheckIn.value = res?.data?.isCheckIn;
                isComplete.value = res?.data?.isComplete;

                events.value = res?.data?.timeKeepings.map((item) => ({
                    id: A(),
                    title: `${item.check_in_time} - ${item.check_out_time}`,
                    start: `${item.checkin_date}T${item.check_in_time}`,
                    end: `${item.checkin_date}T${item.check_out_time}`,
                    className: "fc-event-solid-primary fc-event-light",
                }));

                console.log(events.value, 'event');
            })
            .catch((error) => {
                console.log(error);
            })
            .finally(() => {
                KTApp.hidePageLoading();
            });
    };

    const errors = ref([]);

    const updateTimekeeping = () => {
        KTApp.showPageLoading();
        axios
            .put("/timekeepings/update", {is_checkin: isCheckIn.value})
            .then((res) => {
                errors.value = [];
                useToast.successToast(res.data.message);
                const calendar = KTAppCalendar();

                getInfoTimekeeping().then(() => {
                    calendar.init();
                });
            })
            .catch((error) => {
                errors.value = error.response?.data?.errors;
                if(error.response?.data?.code == 403) {
                    useToast.errorToast(error.response.data?.errors?.message);
                }
            }).finally(()=>{
            KTApp.hidePageLoading();
        });
    };

    var KTAppCalendar = function() {
        "use strict";
        // Dán TOÀN BỘ nội dung hàm KTAppCalendar ở đây
        // Bao gồm tất cả các biến và hàm bên trong
        var e, t, n, a, o, r, i, l, d, c, s, m, u, v, f, p, y, D, k, _, g, b, S, h, T, Y, w, L, E, M = {
            id: "",
            eventName: "",
            eventDescription: "",
            eventLocation: "",
            startDate: "",
            endDate: "",
            allDay: !1
        };

        const
            B = () => {
                var e, t, n;
                w.show(), M.allDay ? (e = "All Day", t = moment(M.startDate).format("Do MMM, YYYY"), n = moment(M.endDate).format("Do MMM, YYYY")) : (e = "", t = moment(M.startDate).format("Do MMM, YYYY - h:mm a"), n = moment(M.endDate).format("Do MMM, YYYY - h:mm a")), g.innerText = M.eventName, b.innerText = e, S.innerText = M.eventDescription ? M.eventDescription : "--", h.innerText = M.eventLocation ? M.eventLocation : "--", T.innerText = t, Y.innerText = n
            },

            C = () => {
                t.value = M.eventName ? M.eventName : "", n.value = M.eventDescription ? M.eventDescription : "", a.value = M.eventLocation ? M.eventLocation : "", r.setDate(M.startDate, !0, "Y-m-d");
                const e = M.endDate ? M.endDate : moment(M.startDate).format();
                l.setDate(e, !0, "Y-m-d");
                const o = f.querySelector("#kt_calendar_datepicker_allday"),
                    i = f.querySelectorAll('[data-kt-calendar="datepicker"]');
                M.allDay ? (o.checked = !0, i.forEach((e => {
                    e.classList.add("d-none")
                }))) : (c.setDate(M.startDate, !0, "Y-m-d H:i"), m.setDate(M.endDate, !0, "Y-m-d H:i"), l.setDate(M.startDate, !0, "Y-m-d"), o.checked = !1, i.forEach((e => {
                    e.classList.remove("d-none")
                })))
            },
            N = e => {
                M.id = e.id, M.eventName = e.title, M.eventDescription = e.description, M.eventLocation = e.location, M.startDate = e.startStr, M.endDate = e.endStr, M.allDay = e.allDay
            },
            A = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();

        return {
            init: function() {
                const H = document.getElementById("kt_modal_view_event");
                var F, O, I, R, V, P;
                w = new bootstrap.Modal(H), g = H.querySelector('[data-kt-calendar="event_name"]'), b = H.querySelector('[data-kt-calendar="all_day"]'), S = H.querySelector('[data-kt-calendar="event_description"]'), h = H.querySelector('[data-kt-calendar="event_location"]'), T = H.querySelector('[data-kt-calendar="event_start_date"]'), Y = H.querySelector('[data-kt-calendar="event_end_date"]'), L = H.querySelector("#kt_modal_view_event_edit"), E = H.querySelector("#kt_modal_view_event_delete"), F = document.getElementById("kt_calendar_app"), O = moment().startOf("day"), I = O.format("YYYY-MM"), R = O.clone().subtract(1, "day").format("YYYY-MM-DD"), V = O.format("YYYY-MM-DD"), P = O.clone().add(1, "day").format("YYYY-MM-DD"), (e = new FullCalendar.Calendar(F, {
                    locale: 'vi',
                    headerToolbar: {
                        left: "prev,next",
                        center: "title",
                        right: ""
                    },
                    initialDate: V,
                    navLinks: !0,
                    selectable: !0,
                    selectMirror: !0,
                    displayEventTime: false, // ✅ Thêm dòng này để tắt "8a", "9a"
                    select: function(e) {
                        N(e), x()
                    },
                    eventClick: function(e) {
                        N({
                            id: e.event.id,
                            title: e.event.title,
                            description: e.event.extendedProps.description,
                            location: e.event.extendedProps.location,
                            startStr: e.event.startStr,
                            endStr: e.event.endStr,
                        }), B()
                    },
                    editable: !0,
                    dayMaxEvents: !0,
                    events: events.value,
                    eventContent: function (arg) {
                        const [checkIn, checkOut] = arg.event.title.split(' - ');
                        return {
                            html: `<div style="color:blue"><b> ✅ Vào: ${checkIn}<br/> <br/><br/>✅ Ra: ${checkOut}</b></div>`
                        };
                    },
                    datesSet: function() {}
                })).render()(C)

            }
        };

    };

    onMounted(() => {
        const calendar = KTAppCalendar();

        getInfoTimekeeping().then(() => {
            calendar.init();
        });
    });
</script>

<style scoped>
.fc-dayGridMonth-button {
    display: none;
}
</style>
