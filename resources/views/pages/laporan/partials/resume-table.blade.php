@props([
    'resume' => [],
    'total' => [],
    'isSheet' => false
])

<div class="resume-table-wrapper {{ $isSheet ? 'resume-table-wrapper--sheet' : '' }}">
    <table class="resume-table">
        <thead>
            <tr>
                <th class="th-kategori">KATEGORI</th>
                <th class="th-num">SALDO AWAL (Rp)</th>
                <th class="th-num">PEMASUKAN (Rp)</th>
                <th class="th-num">PENGELUARAN (Rp)</th>
                <th class="th-num">SALDO AKHIR (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resume as $row)
            <tr class="resume-tr">
                <td class="td-kategori">
                    <span class="trx-row__category trx-row__category--{{ $row['cat_color'] }}">
                        <span class="trx-cat-dot"></span>
                        {{ $row['category'] }}
                    </span>
                </td>
                <td class="td-num">{{ $row['saldo_awal'] }}</td>
                <td class="td-num td-num--green">{{ $row['pemasukan'] }}</td>
                <td class="td-num td-num--red">{{ $row['pengeluaran'] }}</td>
                <td class="td-num td-num--bold">{{ $row['saldo_akhir'] }}</td>
            </tr>
            @endforeach
            <tr class="resume-tr resume-tr--total">
                <td class="td-kategori td-total-label">TOTAL</td>
                <td class="td-num td-total-num">{{ $total['saldo_awal'] }}</td>
                <td class="td-num td-total-num td-num--green">{{ $total['pemasukan'] }}</td>
                <td class="td-num td-total-num td-num--red">{{ $total['pengeluaran'] }}</td>
                <td class="td-num td-total-num td-num--bold">{{ $total['saldo_akhir'] }}</td>
            </tr>
        </tbody>
    </table>
</div>
