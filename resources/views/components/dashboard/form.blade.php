 <form class="space-y-8">
                <!-- Hero Section: Title -->
                <div class="relative group">
                    <input
                        class="w-full bg-transparent border-none text-4xl font-extrabold tracking-tight text-on-surface placeholder:text-surface-variant focus:ring-0 px-0 py-4"
                        placeholder="Masukkan Judul Agenda Rapat..." type="text" />
                    <div
                        class="absolute bottom-0 left-0 w-full h-[2px] bg-surface-container-highest group-focus-within:bg-primary transition-colors">
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-8">
                    <!-- Left Column: Details -->
                    <div class="col-span-12 lg:col-span-8 space-y-8">
                        <!-- Details Card -->
                        <section
                            class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10 shadow-sm">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="col-span-2 md:col-span-1 space-y-2">
                                    <label
                                        class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Tanggal
                                        Rapat</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-primary text-xl"
                                            data-icon="calendar_month">calendar_month</span>
                                        <input
                                            class="w-full bg-surface-container-low border-none rounded-lg py-3 pl-12 pr-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20"
                                            type="date" />
                                    </div>
                                </div>
                                <div class="col-span-2 md:col-span-1 grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Mulai</label>
                                        <input
                                            class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20"
                                            type="time" />
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Selesai</label>
                                        <input
                                            class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20"
                                            type="time" />
                                    </div>
                                </div>
                                <div class="col-span-2 space-y-2">
                                    <div class="flex justify-between items-center">
                                        <label
                                            class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Lokasi
                                            Rapat</label>
                                        <button class="text-xs font-bold text-primary hover:underline"
                                            type="button">Lihat semua lokasi</button>
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-primary text-xl"
                                            data-icon="map">map</span>
                                        <select
                                            class="w-full bg-surface-container-low border-none rounded-lg py-3 pl-12 pr-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 appearance-none">
                                            <option>Pilih Ruang Rapat</option>
                                            <option>Ruang Galaksi - Lantai 4</option>
                                            <option>Ruang Cakrawala - Lantai 2</option>
                                            <option>Virtual Zoom Meeting</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-2 space-y-2">
                                    <label
                                        class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Deskripsi
                                        / Ringkasan</label>
                                    <textarea
                                        class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 resize-none"
                                        placeholder="Tuliskan detail singkat mengenai tujuan rapat..."
                                        rows="4"></textarea>
                                </div>
                            </div>
                        </section>
                        <!-- Agenda Items Section -->
                        <section
                            class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/10 shadow-sm">
                            <div class="p-6 border-b border-surface-container">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-bold text-on-surface">Agenda Items</h3>
                                    <button
                                        class="flex items-center gap-2 text-sm font-bold text-primary px-4 py-2 hover:bg-primary/5 rounded-lg transition-colors"
                                        type="button">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="add_circle">add_circle</span>
                                        Tambah Poin
                                    </button>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead class="bg-surface-container-low">
                                        <tr>
                                            <th
                                                class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
                                                No</th>
                                            <th
                                                class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
                                                Topik</th>
                                            <th
                                                class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
                                                Penanggung Jawab</th>
                                            <th
                                                class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
                                                Durasi</th>
                                            <th
                                                class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-on-surface-variant text-right">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-surface-container">
                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                            <td class="px-6 py-4 text-sm font-medium">1</td>
                                            <td class="px-6 py-4">
                                                <input
                                                    class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full font-medium"
                                                    type="text" value="Pembukaan &amp; Evaluasi Q3" />
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div
                                                        class="w-6 h-6 rounded-full bg-primary-container/20 flex items-center justify-center text-[10px] font-bold text-primary">
                                                        AM</div>
                                                    <span class="text-sm">Andi Mahendra</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-on-surface-variant">15 Menit</td>
                                            <td class="px-6 py-4 text-right">
                                                <button
                                                    class="p-2 text-error opacity-0 group-hover:opacity-100 transition-opacity"
                                                    type="button">
                                                    <span class="material-symbols-outlined text-lg"
                                                        data-icon="delete">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="hover:bg-surface-container-low transition-colors group">
                                            <td class="px-6 py-4 text-sm font-medium">2</td>
                                            <td class="px-6 py-4">
                                                <input
                                                    class="bg-transparent border-none p-0 text-sm focus:ring-0 w-full font-medium"
                                                    placeholder="Tulis topik..." type="text" />
                                            </td>
                                            <td class="px-6 py-4">
                                                <button class="text-xs text-primary font-bold" type="button">+
                                                    Pilih</button>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-on-surface-variant">0 Menit</td>
                                            <td class="px-6 py-4 text-right">
                                                <button
                                                    class="p-2 text-error opacity-0 group-hover:opacity-100 transition-opacity"
                                                    type="button">
                                                    <span class="material-symbols-outlined text-lg"
                                                        data-icon="delete">delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                    <!-- Right Column: Sidebar -->
                    <div class="col-span-12 lg:col-span-4 space-y-8">
                        <!-- Participants Section -->
                        <section
                            class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-6">Peserta
                                Rapat</h3>
                            <!-- Search & Add -->
                            <div class="relative mb-6">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400"
                                    data-icon="person_add">person_add</span>
                                <input
                                    class="w-full bg-surface-container-low border-none rounded-lg py-3 pl-10 pr-4 text-sm focus:bg-white focus:ring-2 focus:ring-primary/20"
                                    placeholder="Cari nama atau email..." type="text" />
                            </div>
                            <div class="space-y-3">
                                <!-- Participant Item -->
                                <div class="flex items-center justify-between p-3 bg-surface rounded-lg group">
                                    <div class="flex items-center gap-3">
                                        <img alt="Sarah" class="w-8 h-8 rounded-full object-cover"
                                            data-alt="Portrait of a female business analyst in a corporate office setting with professional lighting"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRALpzCHyp9QjwcOWuot-EhBmlHAIz4S1iBC9JTN549UMWWupGGbRFMzSIy2B6W4NQLncioTHqqFK70g6LPvkLzLodTP-dIXc8qeGYAynNVnmuRcDsNWxyg5Uf5b0dp3f31S5p1vVec38iNXjHqIqFNlq7JcTC0SkigSe4FN_evo9li2hfZaSJ_xCsIsPXGrDZ29EGQvVy-tGmVibURV9pcff3gzpCnxfJPOBzORqO4joyr2oOysehJNhpJOEruAM7HhnkOyxp8xER" />
                                        <div>
                                            <p class="text-sm font-semibold">Sarah Wijaya</p>
                                            <p class="text-[10px] text-on-surface-variant">Head of Product</p>
                                        </div>
                                    </div>
                                    <button
                                        class="text-on-surface-variant hover:text-error opacity-0 group-hover:opacity-100 transition-opacity"
                                        type="button">
                                        <span class="material-symbols-outlined text-lg" data-icon="close">close</span>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-surface rounded-lg group">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center text-xs font-bold text-on-secondary-container">
                                            BK</div>
                                        <div>
                                            <p class="text-sm font-semibold">Budi Kusuma</p>
                                            <p class="text-[10px] text-on-surface-variant">Marketing Lead</p>
                                        </div>
                                    </div>
                                    <button
                                        class="text-on-surface-variant hover:text-error opacity-0 group-hover:opacity-100 transition-opacity"
                                        type="button">
                                        <span class="material-symbols-outlined text-lg" data-icon="close">close</span>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-surface rounded-lg group">
                                    <div class="flex items-center gap-3">
                                        <img alt="David" class="w-8 h-8 rounded-full object-cover"
                                            data-alt="Corporate professional male in a suit standing in a modern office hallway with soft lighting"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBL3jCgL2p-Wa1tNIa6AWwAx9MYg4AJ0tpK6W_PA5r8FEs0ytcPsCls6Uu0KhN13IMDoakDJKwQaONucZbcVG4NQy2O_IE-v8sOOLcDMkfZOzGm4fPylna134mDQOXiqse-rZXzr9JdmgKiv1wmAZgU6MfU8RTHHcbMd9AhQVdOqaEEpZhotTjYQwH1H0Z3Mbd-EJeXaJPB0EvyqvDwrkEWoqcShWKeAFOI7sP8TuYx3lr5JEd_8b0jSGycLHtEqxIIaPhhCoDB8vzK" />
                                        <div>
                                            <p class="text-sm font-semibold">David Santoso</p>
                                            <p class="text-[10px] text-on-surface-variant">CFO</p>
                                        </div>
                                    </div>
                                    <button
                                        class="text-on-surface-variant hover:text-error opacity-0 group-hover:opacity-100 transition-opacity"
                                        type="button">
                                        <span class="material-symbols-outlined text-lg" data-icon="close">close</span>
                                    </button>
                                </div>
                            </div>
                        </section>
                        <!-- Attachments Section -->
                        <section
                            class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-on-surface-variant mb-6">
                                Lampiran File</h3>
                            <div
                                class="border-2 border-dashed border-outline-variant/30 rounded-xl p-8 flex flex-col items-center justify-center text-center group hover:border-primary transition-colors cursor-pointer">
                                <span
                                    class="material-symbols-outlined text-3xl text-surface-variant group-hover:text-primary mb-2"
                                    data-icon="cloud_upload">cloud_upload</span>
                                <p class="text-sm font-semibold mb-1">Upload atau seret file</p>
                                <p class="text-[10px] text-on-surface-variant">PDF, PPT, DOCX (Maks 10MB)</p>
                            </div>
                        </section>
                        <!-- Map Preview -->
                        <section
                            class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/10 shadow-sm h-48 relative">
                            <img alt="Map of Jakarta" class="w-full h-full object-cover grayscale opacity-50"
                                data-alt="Modern digital map view of an urban city center with clean lines and soft blue tones"
                                data-location="Jakarta"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDdDbIKpmkXoHsxhyqGyf2O4gu5wWc96KLWerZYvM0WbwruLnoCrf7IKPDpnZHLkPFalt3D2c2BBNsfLv_SdRfkBrI-8SRbxzZp__M8Xdeix7TpmQJ1PG9v80sDRI4WMlrB6SqfpDJw4oKDQG6ibZ2hJYah6r2s2z26bZe3rPmhu0F1P1-DD1mn_yI05p0X1bNveqDK3K57ddJ_kK5zB8YGUdipayHXz1wJ1lj5ZAOLHfd6nUsBBGgnjlX6VVQCHSP3VzL6M5aP5Jo-" />
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white/90 backdrop-blur p-2 rounded-lg shadow-xl flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary" data-icon="location_on"
                                        style="font-variation-settings: 'FILL' 1;">location_on</span>
                                    <span class="text-xs font-bold">Pusat Bisnis Jakarta</span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- Sticky Actions Footer -->
                <div class="flex justify-end items-center gap-4 pt-12 pb-16">
                    <button
                        class="px-8 py-3 rounded-lg font-bold text-sm text-on-surface-variant hover:bg-surface-container-high transition-colors"
                        type="button">
                        Simpan sebagai Draft
                    </button>
                    <button
                        class="px-10 py-3 rounded-lg font-bold text-sm text-on-tertiary-container bg-gradient-to-r from-tertiary to-tertiary-container shadow-lg shadow-tertiary/20 hover:opacity-90 transition-opacity flex items-center gap-2"
                        type="submit">
                        <span class="material-symbols-outlined text-lg" data-icon="send">send</span>
                        Jadwalkan Rapat
                    </button>
                </div>
            </form>
