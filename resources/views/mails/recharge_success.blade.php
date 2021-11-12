<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<table style="margin: 0 auto; width: 600px; border-collapse: collapse; background-color: #ffffff;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 0px 10px;" colspan="2">
<table style="width: 100%; border-collapse: collapse;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 0px 25px; color: #333333; font-family: Arial; border-top: 1px solid #cbcbcb;">
<p style="font-size: 16px; font-weight: bold; color: #333333; font-family: Arial; text-align: center;">Th&ocirc;ng tin nạp tiền v&agrave;o t&agrave;i khoản</p>
<p style="font-size: 15px; line-height: 180%; margin: 10px 0px; color: #333333; font-family: Arial;">Xin ch&agrave;o <a href="mailto:{{$owner->email}}" target="_blank" rel="noopener">{{$owner->email}}</a>,</p>
<p style="font-size: 14px; line-height: 180%; margin: 10px 0px; color: #333333; font-family: Arial;">Cảm ơn qu&yacute; kh&aacute;ch đ&atilde; sử dụng dịch vụ của <a href="{{config('app.url')}}" target="_blank" rel="noopener">{{config('app.name')}}</a>. Th&ocirc;ng tin giao dịch nạp tiền của qu&yacute; kh&aacute;ch như sau:</p>
<table style="width: 100%; border-collapse: collapse; border: none; font-size: 14px; line-height: 180%; margin: 10px 0px; color: #333333; font-family: Arial;" border="0">
<tbody>
<tr>
<td style="width: 40%;">M&atilde; giao dịch:</td>
<td style="text-align: right;"><strong>{{$bill->bill_code}}</strong></td>
</tr>
<tr>
<td>Thời gian giao dịch:</td>
<td style="text-align: right;">{{\Carbon\Carbon::parse($bill->updated_at)->format('d-m-y H:i:s A')}}</td>
</tr>
<tr>
<td>Phương thức thanh to&aacute;n:</td>
<td style="text-align: right;">{{$payment_type}}</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
<td><strong>Số tiền đ&atilde; nạp:</strong></td>
<td style="text-align: right;"><strong>{{number_format($bill->amount_of_money,0,'.', '.')}} đ</strong></td>
</tr>
</tbody>
</table>
<p style="font-size: 14px; line-height: 180%; margin: 10px 0px; color: #333333; font-family: Arial;">Nếu Qu&yacute; kh&aacute;ch cần hỗ trợ, vui l&ograve;ng li&ecirc;n hệ hotline <a style="font-size: 14px; color: #333333; font-family: Arial; text-decoration: none;" href="tel:{{$theme_options['Số_điện_thoại']}}" target="_blank" rel="noopener">{{$theme_options['Số_điện_thoại']}}</a> hoặc email <a href="mailto:{{$theme_options['Email_công_ty']}}" target="_blank" rel="noopener">{{$theme_options['Email_công_ty']}}</a> để được trợ gi&uacute;p.</p>
{{-- <p style="font-size: 14px; line-height: 180%; margin: 10px 0px; color: #333333; font-family: Arial;">Nếu Qu&yacute; kh&aacute;ch cần hỗ trợ, vui l&ograve;ng li&ecirc;n hệ hotline <a style="font-size: 14px; color: #333333; font-family: Arial; text-decoration: none;" href="tel:{{$theme_options['Số_điện_thoại']}}" target="_blank" rel="noopener">{{$theme_options['Số_điện_thoại']}}</a> hoặc email <a href="mailto:{{$theme_options['Email_c&ocirc;ng_ty']}}" target="_blank" rel="noopener">{{$theme_options['Email_c&ocirc;ng_ty']}}</a> để được trợ gi&uacute;p.</p> --}}
<p style="font-size: 14px; line-height: 180%; margin: 10px 0px; color: #333333; font-family: Arial;">Tr&acirc;n trọng cảm ơn,<br /><a style="font-size: 14px; color: #333333; font-family: Arial; text-decoration: none;" href="{{config('app.url')}}" target="_blank" rel="noopener">{{config('app.name')}}</a></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td style="border-top: 2px solid #055699;" colspan="2">
<p style="font-size: 16px; color: #333333; font-family: Arial; text-align: center; font-weight: bold;">C&ocirc;ng ty Cổ phần PropertyGuru Việt Nam</p>
<p style="font-size: 12px; color: #333333; font-family: Arial; text-align: center;">Tầng 31, Keangnam Hanoi Landmark Tower, H&agrave; Nội<br />hotline <a style="font-size: 12px; color: #333333; font-family: Arial; text-decoration: none;" href="tel:19001881" target="_blank" rel="noopener">1900 1881</a>.<br /><a style="font-size: 12px; color: #333333; font-family: Arial; text-decoration: none;" href="mailto:hotro@batdongsan.com.vn" target="_blank" rel="noopener">hotro@batdongsan.com.vn</a></p>
</td>
</tr>
</tbody>
</table>
</body>
</html>
