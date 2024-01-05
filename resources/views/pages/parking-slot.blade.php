@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="py-4 border-bottom">
                    <div class="float-left">
                        <a href="{{ route('dashboard') }}" class="badge bg-white back-arrow"><i class="las la-angle-left"></i></a>
                    </div>
                    <div class="form-title text-center">
                        <h3>ที่จอดรถสาขา: @{{ parking.name }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="d-flex flex-wrap justify-content-between mb-4 calender-account">
                    <div class="title">
                        <h4>ช่องจอดรถ</h4>
                    </div>
                    <div class="d-flex align-items-center">
                        <a href="#" @click.prevent="addParkingSlot" class="btn btn-primary pr-5 mr-2 position-relative">
                            เพิ่มช่องจอดรถ<span class="event-add-btn"><i class="ri-add-line"></i></span>
                        </a>
                        <button type="button" data-toggle="modal" data-target="#checkInModal" class="btn btn-orange">เช็คอิน (ทดสอบ) <i class="la la-cab"></i></button>
                    </div>
                </div>
                <div class="card card-block card-stretch calender-account" v-for="(parkingSlot, index) in parkingSlots" :key="index">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            <div class="media flex-wrap align-items-center">
                                <div class="icon iq-icon-box-2 box-shadow rounded-circle mr-3">
                                    <i :class="`las la-car ${parkingSlot.status !== 0 ? 'text-muted' : ''}`"></i>
                                </div>
                                <div v-if="parkingSlot.status === 0">
                                    <h6>ทะเบียน: @{{ parkingSlot.car_park.license_plate }}</h6>
                                    <small>เช็คอิน: @{{ dateParse(parkingSlot.car_park.check_in) }}</small>
                                </div>
                                <div v-else>
                                    <div class="badge badge-color ml-3 mt-0">ช่องจอดว่าง</div>
                                </div>
                            </div>
                            <div class="disconnect-btn">
                                <button class="btn btn-outline-danger" @click.prevent="checkOut(parkingSlot.id)" v-if="parkingSlot.status === 0"><i class="las la-plug"></i> เช็คเอ้าท์</button>
                                <a v-else href="#" class="text-muted" @click.prevent="deleteParkingSlot(parkingSlot.id)"><i class="las la-trash pr-2"></i>ลบช่องจอดรถ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form @submit.prevent="testCheckIn" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkInModalLabel">เช็คอิน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="licensePlate">หมายเลขทะเบียน</label>
                        <input type="text" class="form-control" v-model="checkInForm.license_plate" id="licensePlate" placeholder="กรุณากรอกหมายเลขทะเบียน">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">เช็คอิน</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="checkOutModal" tabindex="-1" role="dialog" aria-labelledby="checkOutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form @submit.prevent="testCheckIn" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkOutModalLabel">รายละเอียดการเช็คเอ้าท์</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>หมายเลขทะเบียน</label>
                        <input type="text" class="form-control" v-model="checkOutSummary.licensePlate" readonly>
                    </div>
                    <div class="form-group">
                        <label>เช็คอิน</label>
                        <input type="text" class="form-control" v-model="checkOutSummary.checkIn" readonly>
                    </div>
                    <div class="form-group">
                        <label>เช็คเอ้าท์</label>
                        <input type="text" class="form-control" v-model="checkOutSummary.checkOut" readonly>
                    </div>
                    <div class="form-group">
                        <label>ค่าบริการ</label>
                        <input type="text" class="form-control" v-model="checkOutSummary.parkingFee" readonly>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const parking = {!! json_encode($parking) !!};

        const { createApp, ref, reactive, onMounted } = Vue;

        createApp({
            setup() {

                const parkingSlots = ref([]);
                const loadParkingSlots = async () => {
                    const { data: response } = await axios.get(route('parking-slots.index', parking.id));
                    parkingSlots.value = response.data;
                }


                const addParkingSlot = async () => {
                    await axios.post(route('parking-slots.store', parking.id));
                    return loadParkingSlots();
                }

                const deleteParkingSlot = async (id) => {
                    await axios.delete(route('parking-slots.destroy', id));
                    return loadParkingSlots();
                }

                const checkInForm = reactive({
                    'license_plate': null,
                });
                const testCheckIn = async () => {
                    await axios.post(route('car-parks.check-in', parking.id), checkInForm);
                    hideModal('#checkInModal');
                    return loadParkingSlots();
                }

                const checkOutSummary = reactive({
                    'licensePlate': null,
                    'checkIn': null,
                    'checkOut': null,
                    'parkingFee': null,
                });
                const checkOut = async (id) => {
                    const { data: response } = await axios.post(route('car-parks.check-out', id));
                    checkOutSummary.licensePlate = response.data.license_plate;
                    checkOutSummary.checkIn = dateParse(response.data.check_in);
                    checkOutSummary.checkOut = dateParse(response.data.check_out);
                    checkOutSummary.parkingFee = response.data.parking_fee;
                    showModal('#checkOutModal');
                    return loadParkingSlots();
                }

                onMounted(() => {
                    loadParkingSlots();
                });

                return {
                    parking,
                    parkingSlots,
                    addParkingSlot,
                    deleteParkingSlot,
                    checkInForm,
                    testCheckIn,
                    dateParse,
                    checkOut,
                    checkOutSummary
                }
            }
        }).mount('#app');
    </script>
@endsection
