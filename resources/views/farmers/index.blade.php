<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Daftar Mitra Petani')}}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3">Nama Petani</th>
                  <th scope="col" class="px-6 py-3">NIK</th>
                  <th scope="col" class="px-6 py-3">Luas Lahan (Ha)</th>
                  <th scope="col" class="px-6 py-3">Kapasitas Max (Ton)</th>
                  <th scope="col" class="px-6 py-3">Status</th>
                  <th scope="col" class="px-6 py-3">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($farmers as $farmer)
                <tr class="bg-white border-b hover:bg-gray-50">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $farmer->full_name }}
                    <div class="text-xs text-gray-400">Grade: {{$farmer->current_grade}}</div>
                  </th>
                  <td class="px-6 py-4">{{ $farmer->nik }}</td>
                  <td class="px-6 py-4">{{ $farmer->land_area_ha}} Ha</td>
                  <td class="px-6 py-4">{{ $farmer->yield_capacity_limit}} Ton</td>
                  <td class="px-6 py-4">
                    @if($farmer->status == 'active')
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded"">Active</span>
                    @elseif($farmer->status == 'suspended')
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Suspended</span>
                    @else<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Blacklisted</span>
                    @endif
                  </td>
                  <td class="px-6 py-4">
                    <a href="{{ route('farmers.show', $farmer)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-4">
            {{ $farmers->links() }}
        </div>>
      </div>
    </div>
  </div>
</x-app-layout>