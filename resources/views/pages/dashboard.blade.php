@extends('layouts.master')

@section('content')
    <div class="content-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 my-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="navbar-breadcrumb">
                            <h1 class="mb-3">ระบบจัดการที่จอดรถ</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 tab-extra" id="view-event">
                    <div class="float-md-right mb-4"><a href="#event1" class="btn view-btn">View Event</a></div>
                </div>
            </div>
            <div class="tab-extra active" id="search-with-button">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <div class="iq-search-bar search-device mb-0 pr-3">
                        <form action="#" class="searchbox">
                            <input type="text" class="text search-input" placeholder="Search...">
                        </form>
                    </div>
                    <div class="float-sm-right">
                        <a href="#" data-toggle="modal" data-target="#addParkingModal" class="btn btn-primary pr-5 position-relative" style="height: 40px;">
                            ที่จอดรถ <span class="event-add-btn" style="height: 40px;"><i class="ri-add-line"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="event-content">
                    <div id="event1" class="tab-pane fade active show">
                        <div class="row">
                            <div class="col-lg-4 col-md-6" v-for="(parking, index) in parkings" :key="index">
                                <div class="card card-block card-stretch card-height">
                                    <div class="card-body rounded event-detail event-detail-info">
                                        <div class="d-flex align-items-top justify-content-between">
                                            <div>
                                                <h4 class="mb-2 mr-4">@{{ parking.name }}</h4>
                                                <p class="mb-2 text-info font-weight-500 text-uppercase"><i
                                                        class="las la-clock pr-2"></i>@{{ parking.parking_fee }} ฿ / Hr.</p>
                                                <p class="mb-4 card-description">@{{ parking.address ?? 'ระบบบริหารงานที่จอดรถ' }}</p>
                                                <div class="d-flex align-items-center pt-4">
                                                    <a :href="route('parking-slots', parking.id)" class="btn btn-info mr-3 px-xl-4">
                                                        <i class="las la-car pr-2"></i> @{{ parking.parking_slots.length }}
                                                    </a>
                                                    <a href="#" class="btn btn-outline-info copy px-xl-4"
                                                       data-extra-toggle="copy" title="Copy to clipboard"
                                                       data-toggle="tooltip"><i class="las la-chart-bar pr-2"></i>รายงานสรุปยอด</a>
                                                </div>
                                            </div>
                                            <div class="card-header-toolbar mt-1">
                                                <div class="dropdown">
                                                    <span class="dropdown-toggle" id="dropdownMenuButton02"
                                                          data-toggle="dropdown">
                                                        <i class="ri-more-2-fill"></i>
                                                    </span>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenuButton02">
                                                        <a class="dropdown-item" href="#" @click.prevent="deleteParking(parking.id)"><i class="ri-delete-bin-6-line mr-3"></i>ลบที่จอดรถ</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade create-workform" id="create-event" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Create a Workflow</h4>
                        <div class="mb-3">
                            <h5>When this happens</h5>
                            <div class="content">
                                <div class="form-group mb-0">
                                    <select name="type" class="selectpicker form-control" data-style="py-0">
                                        <option>Select..</option>
                                        <option>New event is scheduled</option>
                                        <option>Before event starts</option>
                                        <option>Event starts</option>
                                        <option>Event ends</option>
                                        <option>Event is canceled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h5 class="mb-3">Do this</h5>
                            <div class="form-group  mb-0">
                                <select name="type" class="selectpicker form-control" data-style="py-0">
                                    <option>Select..</option>
                                    <option>Send email to invitee</option>
                                    <option>Send email to host</option>
                                    <option>Send text to invitee</option>
                                    <option>Send text to host</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
                                <div class="btn btn-outline-primary" data-dismiss="modal">Save</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addParkingModal" tabindex="-1" role="dialog" aria-labelledby="addParkingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-   lg" role="document">
            <form class="modal-content" @submit.prevent="storeParkings">
                <div class="modal-header">
                    <h5 class="modal-title" id="addParkingModalLabel">เพิ่มที่จอดรถ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="parkingName">ชื่อที่จอดรถ</label>
                        <input type="text" class="form-control" v-model="parkingForm.name" id="parkingName" name="parking_name" placeholder="กรุณากรอกชื่อที่จอดรถ" required>
                    </div>
                    <div class="form-group">
                        <label for="parkingAddress">ที่อยู่</label>
                        <input type="text" class="form-control" v-model="parkingForm.address" id="parkingAddress" name="parking_address" placeholder="กรุณากรอกที่อยู่ของที่จอดรถ">
                    </div>
                    <div class="form-group">
                        <label for="parkingFee">ค่าจอดรถต่อชั่วโมง</label>
                        <input type="number" class="form-control" v-model="parkingForm.parking_fee" id="parkingFee" name="parking_fee" placeholder="กรุณากรอกค่าบริการต่อชั่วโมง" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const { createApp, ref, reactive, onMounted } = Vue;

        createApp({
            setup() {
                const parkings = ref([]);
                const loadParkings = async () => {
                    const { data: response } = await axios.get(route('parkings.index'));
                    parkings.value = response.data;
                }

                const parkingForm = reactive({
                    'name': null,
                    'address': null,
                    'parking_fee': null,
                });

                const storeParkings = async () => {
                    const { data: response } = await axios.post(route('parkings.store'), parkingForm);
                    hideModal('#addParkingModal');
                    return loadParkings();
                }

                const deleteParking = async (id) => {
                    const { data: response } = await axios.delete(route('parkings.destroy', id));
                    return loadParkings();
                }

                onMounted(() => {
                    loadParkings();
                });

                return {
                    parkings,
                    parkingForm,
                    storeParkings,
                    deleteParking,
                    route
                }
            }
        }).mount('#app');
    </script>
@endsection
