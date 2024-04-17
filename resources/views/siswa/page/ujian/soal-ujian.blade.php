@extends('frontendmaster')

@section('title')
    <title>Ujian Matematika</title>
@endsection

@section('content')
    <x-layout-siswa>
        <div class="w-full mt-5">
            <h1 class="text-2xl font-bold mb-3">Ujian Matematika</h1>
            <div class="w-100 bg-gray-300 rounded-lg p-5">
            <div class="w-full">
                <ul class="list-soal mt-3">
                    <li class=" my-2 soal-1">
                        <form>
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text text-lg font-semibold">Soal 1.</span>
                                </div>
                                <p>Soal 1 Adalah .....</p>
                            </label>
                            <div class="flex flex-col gap-2 my-3">
                                <div class="form-control parent-opsiSoal-1">
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban A.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban B.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban C.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban D.</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li class=" my-2 soal-1">
                        <form>
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text text-lg font-semibold">Soal 2.</span>
                                </div>
                                <p>Soal 2 Adalah .....</p>
                            </label>
                            <div class="flex flex-col gap-2 my-3">
                                <div class="form-control parent-opsiSoal-1">
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban A.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban B.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban C.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban D.</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </li>
                    <li class="my-2 soal-1">
                        <form>
                            <label class="form-control">
                                <div class="label">
                                    <span class="label-text text-lg font-semibold">Soal 3.</span>
                                </div>
                                <p>Soal 3 Adalah .....</p>
                            </label>
                            <div class="flex flex-col gap-2 my-3">
                                <div class="form-control parent-opsiSoal-1">
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban A.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban B.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban C.</span>
                                    </label>
                                    <label class="label cursor-pointer justify-start">
                                        <input type="radio" name="radio-1" class="radio radio-primary radio-sm"/>
                                        <span class="mx-2">Jawaban D.</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
                <div class="w-full flex justify-end items-end gap-2">
                    <button type="button" class="btn btn-sm btn-success text-white border-2 btn-tambah-soal">
                        Simpan
                    </button>
                    <button type="button" class="btn btn-sm btn-error text-white border-2 btn-tambah-soal">
                        Batalkan
                    </button>
                </div>
            </div>
        </div>
        </div>
    </x-layout-siswa>
@endsection