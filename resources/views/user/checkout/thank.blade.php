@extends('layout')
@section('title', 'Cảm ơn')
@section('content')
<style>
.thank-you {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: linear-gradient(145deg,rgb(28, 155, 45) 0%,rgb(67, 240, 67) 100%);
    color: #fff;
    text-align: center;
    font-family: 'Poppins', sans-serif;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    border-radius: 16px;
    animation: fadeIn 1.5s ease-in-out;
}

.thank-you h1 {
    font-size: 3rem;
    margin-bottom: 20px;
    text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.2);
}

.thank-you p {
    font-size: 1.5rem;
    margin-bottom: 30px;
    line-height: 1.6;
}

.thank-you .btn {
    padding: 15px 30px;
    background-color: #ff6b6b;
    color: #fff;
    font-size: 1.2rem;
    text-decoration: none;
    border-radius: 50px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.thank-you .btn:hover {
    background-color: #ff4757;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    transform: translateY(-5px);
}

@keyframes fadeIn {
    0% { opacity: 0; transform: scale(0.8); }
    100% { opacity: 1; transform: scale(1); }
}

</style>
<div class="thank-you">
    <h1>Cảm ơn bạn đã đặt hàng!</h1>
    <p>Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ liên hệ với bạn sớm.</p>
    <a href="/" class="btn">Quay về trang chủ</a>
</div>
@endsection