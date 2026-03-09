-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2026 at 04:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naill_utopia`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(10) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL COMMENT 'user id',
  `line_1` varchar(200) NOT NULL,
  `line_2` varchar(200) DEFAULT NULL,
  `city` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `postcode` varchar(200) NOT NULL,
  `user_session` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `id`, `line_1`, `line_2`, `city`, `country`, `postcode`, `user_session`) VALUES
(6, 16, '19 street', '', 'Glasgow', 'United Kingdom', 'GA12 32BB', 'k1i3ojg36ki753t6gs35cqfar4'),
(8, 16, '18 street', '', 'Glasgow', 'United Kingdom', 'GA12 32BB', 'k1i3ojg36ki753t6gs35cqfar4'),
(9, 20, '32 street', '', 'Edinburgh', 'United Kingdom', 'ED11 32BB', 'k1i3ojg36ki753t6gs35cqfar4'),
(10, 11, '18 Main Street', '', 'Glasgow City', 'United Kingdom', 'G47 7DAB', 'u1c9lasvged63lto38r6k149n0'),
(11, 19, '123 Street', '', 'Dunoon', 'United Kingdom', 'PA23 8DX', 'u1c9lasvged63lto38r6k149n0'),
(12, 12, '18 Cyde street', '', 'Sunoon', 'United Kingdom', 'PA23 8DX', 'u1c9lasvged63lto38r6k149n0');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `user_session` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `cart_status` enum('active','ordered','empty') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `id`, `user_session`, `created_at`, `cart_status`) VALUES
(26, 20, '', '2026-02-27 22:50:04', 'ordered'),
(28, 11, '', '2026-03-05 22:49:37', 'ordered'),
(29, 11, '', '2026-03-05 22:53:16', 'ordered'),
(30, 16, '', '2026-03-05 22:55:56', 'ordered'),
(31, 16, '', '2026-03-05 23:33:03', 'ordered'),
(37, 19, '', '2026-03-06 00:06:58', 'active'),
(38, 12, '', '2026-03-06 00:21:02', 'ordered'),
(39, 12, '', '2026-03-06 00:22:52', 'ordered'),
(40, 16, '', '2026-03-09 14:23:08', 'ordered'),
(41, 16, '', '2026-03-09 14:23:44', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `nail_size` enum('XS','S','M','L','Custom') NOT NULL,
  `nail_length` enum('S','M','L','XL') NOT NULL,
  `nail_shape` enum('Round','Square','Squoval','Oval','Almond','Coffin','Stiletto') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `custom_size_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `prod_id`, `quantity`, `nail_size`, `nail_length`, `nail_shape`, `price`, `custom_size_id`) VALUES
(77, 26, 6, 1, 'M', 'L', 'Square', 38.00, NULL),
(79, 28, 6, 1, 'M', 'L', 'Round', 38.00, NULL),
(80, 29, 7, 1, 'M', 'L', 'Round', 56.00, NULL),
(81, 30, 16, 1, 'M', 'L', 'Square', 44.00, NULL),
(82, 31, 14, 1, 'M', 'M', 'Round', 39.00, NULL),
(88, 37, 6, 1, 'M', 'M', 'Oval', 38.00, NULL),
(89, 38, 4, 1, 'Custom', 'L', 'Almond', 40.00, 24),
(90, 38, 30, 1, 'Custom', 'M', 'Almond', 46.00, 25),
(91, 39, 11, 1, 'Custom', 'L', 'Almond', 44.00, 26),
(92, 40, 43, 1, 'M', 'M', 'Round', 55.00, NULL),
(93, 41, 17, 1, 'L', 'L', 'Stiletto', 48.00, NULL),
(94, 41, 8, 1, 'L', 'L', 'Stiletto', 55.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `default_image` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `second_image` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `alt` varchar(200) NOT NULL,
  `caption` varchar(129) NOT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `upload_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `default_image`, `second_image`, `alt`, `caption`, `image_title`, `upload_date`) VALUES
(3, '\"..\\/uploads\\/gallery\\/560546659_122251775324233815_4287850451688689391_n_68f259d24917c3.65565653.jpg\"', '\"..\\/uploads\\/gallery\\/560555533_122251775474233815_8835709397552242092_n_68f259d2acc7d6.90998668.jpg\"', 'Pink almond nails with cherry and flower accents', 'Sweet like cherry blossom vibes 🍒🌸', 'Cherry blossom nail', '2025-12-01'),
(5, '\"..\\/uploads\\/gallery\\/510405030_122228783216233815_558860510843353050_n_68f25ac5c266d1.75381559.jpg\"', '\"..\\/uploads\\/gallery\\/509263241_122228783606233815_3424780839961624673_n_68f25ac642fde8.25056410.jpg\"', 'Almond nails with nude base and shiny gold French tips', 'Golden tips, golden mood 💛✨', 'Gold french nails', '2025-12-01'),
(7, '\"..\\/uploads\\/gallery\\/509426591_122228784290233815_3703825836254756581_n_68f25b5f870318.73078681.jpg\"', '\"..\\/uploads\\/gallery\\/509421901_122228784266233815_8551794149120495185_n_68f25b6091e6b2.09235731.jpg\"', 'Almond nails featuring gold swirl details and 3D flower designs', 'Golden bloom energy 🌼💫', 'Gold floral nails', '2025-12-01'),
(10, '\"..\\/uploads\\/gallery\\/508826341_122228784224233815_4280262325416346347_n_68f274185e6623.01346198.jpg\"', '\"..\\/uploads\\/gallery\\/509424691_122228784008233815_1911128851529364881_n_68f27419519a45.19405105.jpg\"', 'Almond nails featuring white patterns and gold accent lines', 'White luxe with a golden twist 🤍✨', 'White gold textured ', '2025-12-01'),
(11, '\"..\\/uploads\\/gallery\\/518201713_122233327382233815_3845251191772588721_n_68f2788b388c85.88691119.jpg\"', '\"..\\/uploads\\/gallery\\/518103470_122233326992233815_2512010460463311169_n_68f2788c3f4978.82244083.jpg\"', 'Nude French nails with 3D pink flower accents', 'Classic French tips with a flirty floral touch 🤍🌸', 'French flower nails', '2025-12-01'),
(12, '\"..\\/uploads\\/gallery\\/517395026_122233327472233815_5939074860521235988_n_68f278be57af13.91799466.jpg\"', '\"..\\/uploads\\/gallery\\/520745356_122235188936233815_7248919944930041738_n_68f278bea7c220.39552208.jpg\"', 'Nude glitter nails with small gold floral designs', 'Soft shimmer with tiny golden blooms ✨🌼', 'Golden glow nails', '2025-12-08'),
(13, '\"..\\/uploads\\/gallery\\/518319765_122233327004233815_586015600697713320_n_68f278e3e826b4.18449801.jpg\"', '\"..\\/uploads\\/gallery\\/518100602_122233326836233815_623621249528414333_n_68f278e44c7a55.29502738.jpg\"', 'Glossy red nails with cherry art and nude accents', 'Bold red vibes with a sweet cherry twist 🍒❤️', 'Cherry red nails', '2025-12-08'),
(14, '\"..\\/uploads\\/gallery\\/518090748_122233326608233815_2837590712992747626_n_68f2799d37ef11.81413594.jpg\"', '\"..\\/uploads\\/gallery\\/518063772_122233327262233815_6375167237403950456_n_68f2799dc45f46.07817447.jpg\"', 'White and silver nails with koi fish, seashell, and pearl designs', 'Under the sea elegance with pearly waves and koi vibes 🐚💙', 'Pearl ocean nails', '2025-12-08'),
(15, '\"..\\/uploads\\/gallery\\/514635676_122231413220233815_2084065460076717871_n_68f279cfe16af1.89325874.jpg\"', '\"..\\/uploads\\/gallery\\/514334851_122231413562233815_4540931957432667158_n_68f279d03a8319.10793518.jpg\"', 'Peach and orange ombre nails with white flower accents', 'Golden hour glow with soft floral charm 🌅🌸', 'Sunset flower nails', '2025-12-08'),
(16, '\"..\\/uploads\\/gallery\\/513569085_122230264844233815_77637249076330986_n_68f27a0e4c09b5.21724142.jpg\"', '\"..\\/uploads\\/gallery\\/511273342_122230265732233815_9037783967513781054_n_68f27a0f2da454.63948013.jpg\"', 'Nude nails with lemon slice and flower details', 'Fresh and juicy citrus tones with a delicate touch 🍋', 'Citrus blush nails', '2025-12-08'),
(17, '\"..\\/uploads\\/gallery\\/504487231_122226678086233815_7370311202589684148_n_68f27a8d88e406.03953049.jpg\"', '\"..\\/uploads\\/gallery\\/504348338_122226678002233815_3958909996607442003_n_68f27a8e6917b9.35379861.jpg\"', 'Nude pink nails with yellow flower and petal accents', 'Delicate nude nails with pastel flowers and glossy 3D petals 🌸💫', 'Floral blush nails', '2025-12-15'),
(18, '\"..\\/uploads\\/gallery\\/505106878_122226677210233815_7251302531126395450_n_68f27b2786acd8.68037926.jpg\"', '\"..\\/uploads\\/gallery\\/504717189_122226677222233815_1383318265150159504_n_68f27b27e61010.95577012.jpg\"', 'Pink and silver ocean inspired nails with floral details', 'Dreamy ocean vibes with starfish, seashells, and chrome waves 🌊✨', 'Pastel ocean nails', '2025-12-15'),
(19, '\"..\\/uploads\\/gallery\\/505138904_122226677264233815_9058037241355324627_n_68f27b4a4db803.85449880.jpg\"', '\"..\\/uploads\\/gallery\\/505268659_122226677456233815_6329305358561649478_n_68f27b4a98e8b9.99333034.jpg\"', 'Red and nude nails with leopard print and floral accents', 'Bold and fierce with a hint of sweet cherry energy 🍒🐆', 'Leopard cherry nails', '2025-12-15'),
(20, '\"..\\/uploads\\/gallery\\/501356080_122224585718233815_699529251278524436_n_68f27b87d50594.67810459.jpg\"', '\"..\\/uploads\\/gallery\\/501619416_122224585826233815_171941599535981654_n_68f27b883967d8.66729371.jpg\"', 'Brown, burgundy and nude nails with gold outlines and gradient effect', 'Rich mocha and burgundy tones with a gold-lined twist ☕✨', 'Mocha burgundy glaze', '2025-12-15'),
(21, '\"..\\/uploads\\/gallery\\/502506765_122224568960233815_2658901243145189633_n_68f27bbbc94401.52058916.jpg\"', '\"..\\/uploads\\/gallery\\/501211937_122224568930233815_1915129205101622647_n_68f27bbc2165c2.49810070.jpg\"', 'Yellow and pink nails with flower and starfish designs', 'Warm sunshine hues and delicate floral details 🌞🌼', 'Sunny bloom nails', '2025-12-15'),
(22, '\"..\\/uploads\\/gallery\\/499398498_122222672426233815_3441020640280300877_n_68f27c9dc575c3.33943332.jpg\"', '\"..\\/uploads\\/gallery\\/499605542_122222672468233815_3193251504830166729_n_68f27c9e28d975.93090891.jpg\"', 'Blue, gold, and white nails with seashell and flower accents', 'Beach-inspired nails with blue waves and golden shells 🌊🐚', 'Ocean breeze nails', '2025-12-22'),
(23, '\"..\\/uploads\\/gallery\\/499239856_122222433440233815_1814576792854530767_n_68f27cc46e5171.92131770.jpg\"', '\"..\\/uploads\\/gallery\\/498672762_122222433446233815_2324566718781088566_n_68f27cc4bc8fb6.53228256.jpg\"', 'Peach ombre nails with 3D flowers and pearl center', 'Soft peach tones with glossy florals and pearl details 🍑✨', 'Peachy glow nails', '2025-12-22'),
(24, '\"..\\/uploads\\/gallery\\/499407862_122222316728233815_4128750931512783604_n_68f27ce58b2381.72717460.jpg\"', '\"..\\/uploads\\/gallery\\/499225326_122222316566233815_7989239186763824192_n_68f27ce5d87c14.20478672.jpg\"', 'Silver and blue nails with star and chrome frame designs', 'Futuristic chrome nails with star accents and mirror shine 🌌💫', 'Celestial mirror nai', '2025-12-22'),
(25, '\"..\\/uploads\\/gallery\\/495570441_122219830616233815_2316689791652785251_n_68f27d16ef93c4.15820076.jpg\"', '\"..\\/uploads\\/gallery\\/495339911_122219830610233815_6607057588835401570_n_68f27d174daac8.02426988.jpg\"', 'Red and nude nails with flower and gold outline details', 'Elegant blend of ruby red and nude with floral charm ❤️🌸', 'Ruby glow nails', '2025-12-22'),
(26, '\"..\\/uploads\\/gallery\\/494750870_122218573364233815_4024569383208611218_n_68f27d7e3566d7.04946103.jpg\"', '\"..\\/uploads\\/gallery\\/494195658_122218573178233815_8879448069523970571_n_68f27d7e748451.09836737.jpg\"', 'Colorful nails with dessert and candy-themed 3D designs', 'Candy-core cuteness that looks good enough to eat 🍓🍬', 'Sweet treat nails', '2025-12-22'),
(27, '\"..\\/uploads\\/gallery\\/494596938_122218589474233815_3646727724702134881_n_68f27dc0a4d722.27425540.jpg\"', '\"..\\/uploads\\/gallery\\/494598528_122218589516233815_644897092793999311_n_68f27dc15f6756.52162772.jpg\"', 'Yellow French nails with 3D floral designs and glossy finish', 'Fresh, juicy, and full of sunshine 🍋🌼☀️', 'Lemon frost nails', '2025-12-29'),
(28, '\"..\\/uploads\\/gallery\\/494225446_122218010480233815_5527517586365260568_n_68f27ddd871d21.94993444.jpg\"', '\"..\\/uploads\\/gallery\\/494840699_122218010372233815_1260138170835164538_n_68f27dddda6e27.22209867.jpg\"', 'Blue and silver nails with chrome swirl details', 'Cool chrome drip with futuristic flair 💿🩶💫', 'Chrome splash nails', '2025-12-29'),
(29, '\"..\\/uploads\\/gallery\\/494639701_122218265540233815_2200541350347880957_n_68f27e6b59b711.54267383.jpg\"', '\"..\\/uploads\\/gallery\\/494218237_122218265486233815_6049072428834241837_n_68f27e6bacbe03.00067466.jpg\"', 'Brown and nude nails with soft gradients and floral gold accents', 'Soft smoke meets pure luxury ☕✨', 'Smoky elegance nails', '2025-12-29'),
(30, '\"..\\/uploads\\/gallery\\/492933133_122217426494233815_6170187523340540495_n_68f27f02350a73.98277179.jpg\"', '\"..\\/uploads\\/gallery\\/494132390_122217426524233815_9162668170519727497_n_68f27f0295b269.00705000.jpg\"', 'Nude and black nails with gold flowers and glossy details', 'Neutral glam with golden blooms and a hint of edge ☕🌼✨', 'Mocha bloom nails', '2025-12-29'),
(31, '\"..\\/uploads\\/gallery\\/494319434_122217718082233815_1446129841584425372_n_68f27f1f68ce28.83437471.jpg\"', '\"..\\/uploads\\/gallery\\/494070227_122217718196233815_7116752292470950059_n_68f27f1fb70567.02024013.jpg\"', 'Burgundy and white nails with 3D flowers and glossy petals', 'Deep burgundy florals that say classy with a twist 🍷🌸', 'Wine petal nails', '2025-12-29'),
(32, '\"..\\/uploads\\/gallery\\/491173196_122215035416233815_2828528445298887624_n_68f27f5c421b39.50406094.jpg\"', '\"..\\/uploads\\/gallery\\/491662314_122215035542233815_4598867268718531981_n_68f27f5c955db4.23393441.jpg\"', 'Nude and deep red nails with 3D gems and gold accents', 'Red luxury meets glassy perfection 💋💎', 'Ruby elegance nails', '2026-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `newsletter_id` int(10) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `newsletter_status` enum('subscribed','unsubscribed') NOT NULL DEFAULT 'unsubscribed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`newsletter_id`, `id`, `email`, `newsletter_status`) VALUES
(1, 12, '', 'subscribed'),
(22, 15, '', 'unsubscribed'),
(26, 11, '', 'subscribed'),
(27, 13, '', 'unsubscribed'),
(29, 16, '', 'subscribed'),
(30, 17, '', 'unsubscribed'),
(31, 18, '', 'unsubscribed'),
(32, 19, '', 'unsubscribed'),
(33, 20, '', 'subscribed'),
(36, 23, '', 'unsubscribed'),
(44, 26, '', 'subscribed'),
(46, 28, '', 'unsubscribed'),
(47, 29, '', 'subscribed');

-- --------------------------------------------------------

--
-- Table structure for table `open_hours`
--

CREATE TABLE `open_hours` (
  `hours_id` tinyint(3) UNSIGNED NOT NULL,
  `day_of_week` varchar(10) NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `open_hours`
--

INSERT INTO `open_hours` (`hours_id`, `day_of_week`, `open_time`, `close_time`, `is_closed`) VALUES
(1, 'Monday', '09:00:00', '18:00:00', 1),
(2, 'Tuesday', '09:00:00', '18:00:00', 1),
(3, 'Wednesday', '09:00:00', '18:00:00', 1),
(4, 'Thursday', '09:00:00', '18:00:00', 1),
(5, 'Friday', '09:00:00', '20:00:00', 1),
(6, 'Saturday', '09:00:00', '13:00:00', 0),
(7, 'Sunday', '09:00:00', '13:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_number` varchar(200) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL,
  `voucher_id` varchar(200) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_status` enum('confirmed','pending','delivered','canceled') NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `delivered_date` date DEFAULT NULL,
  `total_items` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `cart_id`, `discount`, `shipping_fee`, `voucher_id`, `subtotal`, `total`, `order_status`, `address_id`, `order_date`, `delivered_date`, `total_items`) VALUES
(1, 'NU-20260227-00001', 26, 5.00, 4.00, NULL, 38.00, 37.00, 'delivered', 9, '2026-02-27 22:50:19', NULL, 1),
(2, 'NU-20260305-00002', 28, 5.00, 4.00, '1', 38.00, 37.00, 'delivered', 10, '2026-03-05 22:52:06', NULL, 1),
(3, 'NU-20260305-00003', 29, 0.00, 4.00, '1', 56.00, 52.00, 'delivered', 10, '2026-03-05 22:55:02', NULL, 1),
(4, 'NU-20260306-00004', 30, 0.00, 4.00, '2', 44.00, 44.00, 'confirmed', 8, '2026-03-05 23:27:28', NULL, 1),
(5, 'NU-20260306-00005', 31, 5.00, 4.00, NULL, 39.00, 38.00, 'confirmed', 8, '2026-03-05 23:35:37', NULL, 1),
(13, 'NU-20260306-00013', 38, 12.00, 0.00, '1', 86.00, 73.00, 'pending', 12, '2026-03-06 00:22:42', NULL, 3),
(14, 'NU-20260306-00014', 39, 4.00, 4.00, '2', 44.00, 44.00, 'pending', 12, '2026-03-06 01:04:07', NULL, 1),
(15, 'NU-20260309-00015', 40, 0.00, 4.00, '1', 55.00, 51.00, 'pending', 8, '2026-03-09 14:23:38', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pov`
--

CREATE TABLE `pov` (
  `pov_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `upload_date` date NOT NULL DEFAULT current_timestamp(),
  `pov_images` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pov`
--

INSERT INTO `pov` (`pov_id`, `user_id`, `caption`, `upload_date`, `pov_images`) VALUES
(14, 11, 'Nail flex committee meeting 😮‍💨', '2026-02-05', '\"..\\/uploads\\/pov\\/0ceff876-f970-428f-a738-5b0f502fed43.jpg\"'),
(15, 11, 'Baby blue tips, big main character energy 🩵', '2026-02-05', '\"..\\/uploads\\/pov\\/1bec201c-5d8d-43c3-ad3c-ea41fd3182df.jpg\"'),
(18, 19, 'Off to SnS tour 💙☕💋', '2026-02-07', '\"..\\/uploads\\/pov\\/IMG_0559.jpg\"'),
(20, 16, 'who says ocean and prints wouldn\'t go well together???', '2026-02-10', '\"..\\/uploads\\/pov\\/IMG_1124.PNG\"');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `preference_id` int(10) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL,
  `pref_shape` varchar(20) NOT NULL,
  `pref_length` varchar(10) NOT NULL,
  `pref_size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`preference_id`, `id`, `pref_shape`, `pref_length`, `pref_size`) VALUES
(49, 16, 'Almond', 'M', 'S'),
(50, 16, 'Coffin', 'L', 'S'),
(51, 16, 'Coffin', 'XL', 'Custom'),
(52, 16, 'Coffin', 'L', 'Custom'),
(53, 11, 'Round', 'L', 'M'),
(54, 12, 'Almond', 'L', 'Custom'),
(55, 19, 'Oval', 'M', 'M'),
(56, 19, 'Oval', 'M', 'M'),
(57, 16, 'Round', 'M', 'M'),
(58, 16, 'Round', 'M', 'M'),
(59, 16, 'Round', 'M', 'M'),
(60, 16, 'Round', 'M', 'M'),
(61, 16, 'Almond', 'M', 'M'),
(62, 16, 'Stiletto', 'L', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `press_on`
--

CREATE TABLE `press_on` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(20) NOT NULL,
  `prod_price` decimal(10,2) NOT NULL,
  `prod_tag` varchar(255) NOT NULL,
  `prod_color` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `prod_info` varchar(2000) NOT NULL,
  `prod_default_image` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `prod_image` varchar(2048) NOT NULL,
  `prod_discount` int(11) NOT NULL DEFAULT 0,
  `times_bought` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `press_on`
--

INSERT INTO `press_on` (`prod_id`, `prod_name`, `prod_price`, `prod_tag`, `prod_color`, `prod_info`, `prod_default_image`, `prod_image`, `prod_discount`, `times_bought`) VALUES
(2, 'Daydream Blossom', 42.00, '[\"Flower\",\"Pearl Aura\",\"3D\"]', '[\"pink\"]', 'Soft, dreamy, and glowing from every angle — Daydream Blossom is a pastel-aurora set layered with iridescent pink shimmer and finished with delicate 3D milky-white floral sculpture.This design is perfect for brides, soft-girl aesthetics, spring outfits, or anyone who loves a clean but magical glow on their nails.\r\nThe aurora sheen changes under the light like a rainbow mist, while the 3D flowers add a handcrafted luxury detail found only in premium custom sets.', '\"..\\/uploads\\/products\\/Daydream Blossom.webp\"', '[\"..\\/uploads\\/products\\/Daydream Blossom 2.webp\",\"..\\/uploads\\/products\\/Daydream Blossom 1.webp\"]', 0, 0),
(4, 'Blush Dot', 40.00, '[\"Cateye\",\"Minimalist\"]', '[\"neutral\"]', 'Soft, simple, and effortlessly chic — Blush Dot is your go-to minimal press-on nail set for everyday wear.\r\n\r\nThis design features a warm blush-nude base with tiny hand-placed black dots, giving it that clean, modern “cool girl” vibe without ever trying too hard. Whether you\'re going for a laid-back weekend look or want something subtle for work, these nails deliver a polished finish that matches everything in your wardrobe.\r\n\r\nLightweight, natural-looking, and handcrafted with salon-grade gel, Blush Dot is perfect for anyone who loves minimal, aesthetic nails with a playful twist.', '\"..\\/uploads\\/products\\/Blush Dot.webp\"', '[\"..\\/uploads\\/products\\/Blush_Dot_2.webp\",\"..\\/uploads\\/products\\/Blush_Dot_1.webp\"]', 0, 0),
(5, 'Cherry Bomb', 56.00, '[\"Cute\",\"Artistic\"]', '[\"red\",\"white\"]', 'In a dazzling blend of cherry red and crisp white, Cherry Bomb captures the spirit of a sweet rebel.\r\nFeaturing hand-drawn bows, swirls, cherries, and stars, with metallic silver accents, this press-on nail set brings the iconic Y2K aesthetic back to life.\r\nThe gradient hues feel like a sparkling cherry soda—sweet, intoxicating, and a little bit wild.\r\nEach piece is meticulously handcrafted to deliver a vibrant, edgy look perfect for street style, parties, and bold everyday wear.', '\"..\\/uploads\\/products\\/Cherry_Bomb.webp\"', '[\"..\\/uploads\\/products\\/Cherry_Bomb_2.webp\",\"..\\/uploads\\/products\\/Cherry_Bomb_1.webp\"]', 0, 0),
(6, 'Cherry and Bow', 38.00, '[\"Featured\",\"Cute\",\"3D\"]', '[\"black\",\"pink\",\"white\"]', 'Unleash your playful side with our Cherry and Bow Press Ons! This set is a maximalist dream, blending sweet Kawaii style with a touch of dark, edgy glamour. It’s the ultimate statement press on manicure for anyone who can’t choose just one aesthetic—why not rock them all?This is more than just a set of glue on nails; it\'s a curated fashion collection for your fingertips.', '\"..\\/uploads\\/products\\/Cherry_and_bow.webp\"', '[\"..\\/uploads\\/products\\/Cherry_and_bow_1.webp\"]', 0, 0),
(7, 'Cherry Kiss', 56.00, '[\"Cute\",\"Artistic\"]', '[\"red\",\"white\"]', 'Sweet, salty, and totally iconic. The Cherry Kiss collection is the ultimate summer-to-fall transition piece for your wardrobe. Taking inspiration from the viral \"Cherry Girl\" trend and the timeless \"Coquette Aesthetic,\" these nails are designed for the girl who wants her manicure to be the conversation starter.\r\n\r\nWe’ve paired a high-shine classic cherry red with crisp white and soft nude bases to create a look that’s both vintage and futuristic. The stars of the show are the hand-placed 3D glitter cherries—sparkling like candy under the sun—and the dainty silver metallic bows. Wrapped together with delicate micro-pearl chains and fine-line silver detailing, this set delivers that \"Pinterest Perfect\" look without the three-hour salon appointment', '\"..\\/uploads\\/products\\/Cherry_Kiss.webp\"', '[\"..\\/uploads\\/products\\/Cherry_Kiss_6.webp\",\"..\\/uploads\\/products\\/Cherry_Kiss_5.webp\",\"..\\/uploads\\/products\\/Cherry_Kiss_4.webp\",\"..\\/uploads\\/products\\/Cherry_Kiss_3.webp\"]', 0, 0),
(8, 'Cherry Romance', 55.00, '[\"Cute\",\"Artistic\",\"Seasonal\"]', '[\"neutral\",\"red\"]', 'The only holiday accessory you’ll never want to take off.\r\n\r\nDitch the salon rush this December. Holiday Glam is our masterstroke for the season—a curated, artisan-grade set that turns your hands into a festive statement. Designed for the high-octane energy of NYC galas and cozy Aspen getaways alike, these nails bring that \"Custom Atelier\" look directly to your vanity.\r\n\r\nWe’ve reimagined holiday classics by pairing a sultry crimson base with hand-sculpted molten gold chrome. The texture is visceral, mimicking liquid metal flowing over your fingertips. Accented with multi-tonal gemstone mosaics, dainty pearl-centered ribbons, and etched North Stars, this set is a celebration of maximalist elegance. Whether you’re clinking champagne glasses or opening gifts, do it with the confidence of a perfectly curated manicure.', '\"..\\/uploads\\/products\\/Cherry_Romance.webp\"', '[\"..\\/uploads\\/products\\/Cherry_Romance_4.webp\",\"..\\/uploads\\/products\\/Cherry_Romance_3.webp\",\"..\\/uploads\\/products\\/Cherry_Romance_2.webp\",\"..\\/uploads\\/products\\/Cherry_Romance_1.webp\"]', 0, 0),
(10, 'Cosmic Candy', 44.00, '[\"Cute\",\"Chrome\",\"3D\"]', '[\"orange\",\"pink\",\"silver\",\"multicolor\"]', 'Step into a dazzling dream with Cosmic Candy.\r\n\r\nThis press-on nail set captures the iconic spirit of the Y2K era with metallic chrome accents, swirling lines, candy-hued gradients, and 3D embellishments, as if you’re dancing at a cosmic disco.\r\nPink, orange, and lilac shades shimmer together, while the chrome silver and spiral textures add a futuristic twist.', '\"..\\/uploads\\/products\\/Cosmic_Candy.webp\"', '[\"..\\/uploads\\/products\\/Cosmic_Candy1.webp\"]', 0, 0),
(11, 'Holiday Glam', 44.00, '[\"Cute\",\"3D\",\"Seasonal\"]', '[\"gold\",\"red\"]', 'Be the gift that keeps on giving. The Holiday Glam collection is our love letter to the most magical time of the year. Forget subtle—these nails are designed for the high-octane glamour of rooftop holiday parties, candlelit dinners, and New Year’s Eve celebrations.\r\n\r\nWe’ve curated a festive masterpiece that balances tradition with modern luxury. Featuring a base of deep velvet crimson and milky white, each nail is an individual work of art. The set boasts 3D molten gold chrome swirls, hand-placed multi-color gemstone mosaics, and the ultimate coquette touch: ruby-red bows centered with luminous pearls. With etched silver and gold North Stars shimmering across the tips, your hands won\'t just hold a champagne glass—they’ll steal the entire scene.', '\"..\\/uploads\\/products\\/Holiday_Glam.webp\"', '[\"..\\/uploads\\/products\\/Holiday_Glam_3.webp\",\"..\\/uploads\\/products\\/Holiday_Glam_2.webp\",\"..\\/uploads\\/products\\/Holiday_Glam_1.webp\"]', 0, 0),
(13, 'Moonlit Pearl', 44.00, '[\"Cute\",\"3D\",\"Featured\"]', '[\"neutral\",\"white\"]', 'Moonlit Pearl Bridal Press Ons French Ombre Rhinestone\r\nStep into a dreamy garden with Blooming Fantasy handmade press on nails. Featuring delicate 3D floral accents, sparkling rhinestones, and classic white French tips, this set is perfect for anyone who loves a mix of elegance and playful charm.Whether you’re dressing up for spring and summer events, weddings, or simply want a unique everyday look, these handmade press on nails make it effortless to achieve salon-quality results at home.', '\"..\\/uploads\\/products\\/Moonlit_Pearl.webp\"', '[\"..\\/uploads\\/products\\/Moonlit_Pearl2.webp\",\"..\\/uploads\\/products\\/Moonlit_Pearl1.webp\"]', 0, 0),
(14, 'Polka Chic', 39.00, '[\"French Tip\",\"Minimalist\"]', '[\"black\",\"neutral\",\"white\"]', 'Embrace the timeless charm of retro polka dots with our Polka Chic press-on nails. This set features a nude base topped with playful French tips in contrasting black and white polka dot designs. Perfect for adding a touch of vintage elegance to any outfit, from casual denim to evening dresses.', '\"..\\/uploads\\/products\\/Polka_Chic.webp\"', '[\"..\\/uploads\\/products\\/Polka_Chic2.webp\",\"..\\/uploads\\/products\\/Polka_Chic1.webp\"]', 0, 0),
(15, 'Starlight Ribbons', 48.00, '[\"Cute\",\"Chrome\",\"3D\"]', '[\"black\",\"silver\",\"white\"]', 'Soft aesthetic meets high-tech chrome. The Starlight Ribbons set is the ultimate fashion statement for those who refuse to be put in a box. It’s the perfect blend of the viral \"Coquette\" bow obsession and the edgy, futuristic \"Cyber-Grunge\" vibe that’s taking over the streets of NYC and London.\r\n\r\nWe’ve curated a stunning mix of hand-painted bold black ribbons, delicate silver chrome stars, and luxe pearl embellishments. The standout feature is the 3D metallic liquid silver swirls that look like molten chrome dancing across a soft nude and milky white base. It’s feminine yet fierce, classic yet cosmic. This set doesn’t just complement your outfit—it defines your entire aesthetic.', '\"..\\/uploads\\/products\\/Starlight_Ribbons.webp\"', '[\"..\\/uploads\\/products\\/Starlight_Ribbons2.webp\",\"..\\/uploads\\/products\\/Starlight_Ribbons1.webp\"]', 0, 0),
(16, 'Sweet Honey Bee', 44.00, '[\"Cute\",\"3D\",\"Artistic\"]', '[\"neutral\",\"yellow\"]', 'Keep your look blooming all year long. 🐝🌼🍯\r\n\r\nForget basic manis—our Sweet Honey Bee set is a literal garden party at your fingertips. We’ve combined a sophisticated, high-clarity nude jelly base with a vibrant honey-yellow French tip that screams sunshine. It’s the ultimate \"clean girl\" aesthetic with a whimsical, maximalist twist.\r\n\r\nThe stars of the show? Custom, hand-sculpted 3D honey bees that look ready to take flight, paired with delicate, hand-painted white daisies. We’ve added \"honey drop\" white dots to give the design that extra pop of texture. Whether you’re heading to a spring brunch, a graduation party, or just want to feel like a sunshine goddess, these nails deliver a high-end, hand-crafted vibe that you simply can\'t find in a drugstore box.', '\"..\\/uploads\\/products\\/Sweet_Honey_Bee.webp\"', '[\"..\\/uploads\\/products\\/Sweet_Honey_Bee2.webp\",\"..\\/uploads\\/products\\/Sweet_Honey_Bee1.webp\"]', 0, 0),
(17, 'Sweet Chocolate', 48.00, '[\"French Tip\",\"Artistic\",\"Featured\"]', '[\"black\",\"brown\",\"neutral\",\"silver\"]', 'These elegant, handcrafted press-on nails feature a striking combination of deep brown and soft nude tones, accented with star patterns and sparkling Sweet chocolate magic.  Perfect for various occasions,  parties, and romantic dates.    Easy to apply and long-lasting, they allow you to transform your look effortlessly.\r\n\r\n', '\"..\\/uploads\\/products\\/Sweet_chocolate.webp\"', '[\"..\\/uploads\\/products\\/Sweet_chocolate2.webp\",\"..\\/uploads\\/products\\/Sweet_chocolate1.webp\"]', 0, 0),
(18, 'Chrimson Voltage', 55.00, '[\"Aerochrome\"]', '[\"red\",\"multicolor\"]', 'Unleash your inner rebel with our Crimson Voltage Press-On Nails! This dramatic set is an electrifying take on the aura nail trend, giving you a look that\'s both powerful and effortlessly cool. Each nail features a fiery, high-contrast gradient. The design blends a deep, sultry black with a bold crimson red, while the center glows with a vivid, lighter aura effect. The glossy finish gives them a high-end, gel-like shine that truly makes the colors pop. The modern, tapered shape is both edgy and elegant, making these nails the perfect statement piece.', '\"..\\/uploads\\/products\\/Crimson_Voltage.webp\"', '[\"..\\/uploads\\/products\\/Crimson_Voltage_3.webp\",\"..\\/uploads\\/products\\/Crimson_Voltage_2.webp\",\"..\\/uploads\\/products\\/Crimson_Voltage_1.webp\"]', 0, 0),
(19, 'Prims Flux', 55.00, '[\"Aerochrome\"]', '[\"blue\",\"multicolor\"]', 'Bring color to your fingertips with Prism Flux Press On Nails – a bold and vibrant set featuring multicolor gradients and a sleek glossy finish. Perfect for nail lovers in the U.S. who want an instant statement manicure without the salon visit.\r\nThese colorful press on nails give you the freedom to switch styles whenever you want. Whether you’re into rainbow nails, gradient press on nails, or bold artistic manicures, Prism Flux is your go-to set for instant color and confidence.', '\"..\\/uploads\\/products\\/Prism_Flux.webp\"', '[\"..\\/uploads\\/products\\/Prism_Flux_2.webp\",\"..\\/uploads\\/products\\/Prism_Flux_1.webp\"]', 0, 0),
(20, 'Cyber Amethyst', 55.00, '[\"Aerochrome\"]', '[\"purple\",\"multicolor\"]', 'Step into the future of nail fashion with our Cyber Amethyst Press On Nails. Designed with a bold purple gradient and futuristic chrome finish, this handcrafted set is perfect for nail lovers who want a modern, edgy look without the salon wait.', '\"..\\/uploads\\/products\\/Cyber_Amethyst.webp\"', '[\"..\\/uploads\\/products\\/Cyber_Amethyst_1.webp\"]', 0, 0),
(21, 'Smoky Aura', 55.00, '[\"Aerochrome\"]', '[\"black\",\"multicolor\"]', 'Looking for a manicure that’s modern and effortlessly cool? Our Smoky Aura Press-On Nails are the answer. This set is a sleek and sophisticated take on the popular aura trend, featuring a stunning monochromatic design that\'s perfect for any occasion.\r\nEach nail has a clean, stark white border that perfectly frames the moody, smoky black and gray gradient at the center. The effect is a chic, mesmerizing blur that gives your fingertips a mysterious and edgy look. The long, tapered shape is both trendy and flattering, making a bold statement without any extra effort.', '\"..\\/uploads\\/products\\/Smoky_Aura.webp\"', '[\"..\\/uploads\\/products\\/Smoky_Aura_3.webp\",\"..\\/uploads\\/products\\/Smoky_Aura_2.webp\",\"..\\/uploads\\/products\\/Smoky_Aura_1.webp\"]', 0, 0),
(22, 'Monochrome Orbit', 50.00, '[\"Chrome\",\"3D\",\"Artistic\"]', '[\"black\",\"silver\",\"white\"]', 'Turn your nails into a statement with our handmade black and white abstract press on nails. This set features a futuristic mix of swirls, stars, and chrome-inspired details, finished with rhinestone accents for extra shine. Designed for easy application and long-lasting wear, these trendy press on nails are perfect for nights out, special occasions, or whenever you want bold, eye-catching nails without the salon price tag.', '\"..\\/uploads\\/products\\/Monochrome_Orbit.webp\"', '[\"..\\/uploads\\/products\\/Monochrome_Orbit2.webp\",\"..\\/uploads\\/products\\/Monochrome_Orbit1.webp\"]', 0, 0),
(23, 'Cyber Heartbeat', 52.00, '[\"Chrome\",\"3D\",\"Artistic\"]', '[\"black\",\"red\",\"white\"]', 'Upgrade your bio-hardware. The Cyber Heartbeat collection is a high-performance fusion of dark gothic aesthetics and liquid silver technology. This isn\'t just nail art; it\'s a 3D interface for the modern rebel.\r\n\r\nFeaturing a monochromatic palette of obsidian black and sterile white, this set is dominated by sculpted 3D chrome webbing and molten silver star hardware. The standout feature is the hyper-realistic liquid bubble texture, giving the illusion of chrome melting directly onto your fingertips. Designed for raves, tech-wear enthusiasts, and anyone living in the year 3026.', '\"..\\/uploads\\/products\\/Cyber_Heartbeat.webp\"', '[\"..\\/uploads\\/products\\/Cyber_Heartbeat2.webp\",\"..\\/uploads\\/products\\/Cyber_Heartbeat1.webp\"]', 0, 0),
(24, 'Eclipse', 44.00, '[\"Cateye\",\"French Tip\"]', '[\"black\",\"white\"]', 'Ready for a manicure that’s truly out of this world? Our Eclipse Press Ons are here to deliver! This mysterious and chic set captures the dramatic beauty of a solar eclipse, giving your hands an edgy, sophisticated look that’s perfect for making a statement.The design features a mesmerizing aura effect. Each nail is framed by a bold black border that fades into a smoky, misty white center. The striking contrast creates a captivating visual that’s both moody and elegant. The classic oval shape is modern and flattering, designed to elongate your fingers and provide a polished, high-fashion finish.', '\"..\\/uploads\\/products\\/Eclipse.webp\"', '[\"..\\/uploads\\/products\\/Eclipse3.webp\",\"..\\/uploads\\/products\\/Eclipse2.webp\",\"..\\/uploads\\/products\\/Eclipse1.webp\"]', 0, 0),
(25, 'Galactic Whisper', 52.00, '[\"Chrome\",\"3D\",\"Artistic\"]', '[\"black\",\"silver\"]', 'Galactic Whisper feels like a secret softly spoken by the galaxy. Featuring chrome silver, cool-toned nebula gradients, 3D butterflies, and sparkling star accents, this set draws cosmic signals with minimalistic lines. Subtle yet striking—perfect for those who love futuristic, cybercore, and unique fashion styles.', '\"..\\/uploads\\/products\\/Galactic_Whisper.webp\"', '[\"..\\/uploads\\/products\\/Galactic_Whisper2.webp\",\"..\\/uploads\\/products\\/Galactic_Whisper1.webp\"]', 0, 0),
(26, 'Blue Chrome', 50.00, '[\"Chrome\",\"3D\"]', '[\"blue\",\"silver\"]', 'Airbrushed to perfection, finished with molten edge.This set features a surreal chrome-blue gradient base — crafted using airbrush technique — topped with silver metal drips that give off an experimental, otherworldly vibe.\r\nPolished but untamed, it’s made for fashion rebels.', '\"..\\/uploads\\/products\\/Blue Chrome.webp\"', '[\"..\\/uploads\\/products\\/Blue Chrome2.webp\",\"..\\/uploads\\/products\\/Blue Chrome1.webp\"]', 0, 0),
(27, 'Red Pop Galaxy', 44.00, '[\"Cute\",\"Artistic\"]', '[\"neutral\",\"red\"]', 'Turn every night into a cosmic celebration with Red Pop Galaxy Press On Nails. This handcrafted set mixes bold red tones, playful star accents, and glossy 3D rhinestones for a look that’s truly out of this world. Perfect for U.S. nail lovers who want a unique manicure that’s equal parts fun and futuristic.These red galaxy nails are more than just a manicure – they’re a vibe. Whether you’re looking for star nails, cosmic nails, party press on nails, or red rhinestone nails, Red Pop Galaxy is your go-to set for instant starlit glamour.', '\"..\\/uploads\\/products\\/Red_Pop_Galaxy.webp\"', '[\"..\\/uploads\\/products\\/Red_Pop_Galaxy2.webp\",\"..\\/uploads\\/products\\/Red_Pop_Galaxy1.webp\"]', 0, 0),
(28, 'Crimsons Veil', 48.00, '[\"Chrome\"]', '[\"pink\"]', 'Passion meets art.\r\nOur Crimson Veins – Metallic Line Press-On Nails combine a silky crimson base with abstract dark lines and delicate metallic bead detailing. This handmade set adds a sophisticated and daring touch to your fingertips.', '\"..\\/uploads\\/products\\/Crimson_Veins.webp\"', '[\"..\\/uploads\\/products\\/Crimson_Veins2.webp\",\"..\\/uploads\\/products\\/Crimson_Veins1.webp\"]', 0, 0),
(29, 'Polka Pop', 42.00, '[\"Cute\",\"3D\",\"Artistic\"]', '[\"yellow\",\"multicolor\"]', 'Playful, bold, and full of character — meet Polka Pop handmade press on nails. This fun set mixes sunny yellow tones, glossy nude bases, and striking polka dot accents with metallic studs and 3D texture details. Designed to give you a pop of color with a quirky twist, these trendy press on nails are perfect for nail lovers who enjoy playful fashion and eye-catching style.\r\nWhether you’re searching for yellow nails, polka dot press on nails, or statement nail art that feels fresh and fun, this set makes a perfect match. Easy to apply, reusable, and built to last, Polka Pop nails are your go-to for turning everyday looks into something unforgettable.', '\"..\\/uploads\\/products\\/Polka_Pop.webp\"', '[\"..\\/uploads\\/products\\/Polka_Pop_2.webp\",\"..\\/uploads\\/products\\/Polka_Pop_1.webp\"]', 0, 0),
(30, 'Ivory Claw', 46.00, '[\"Chrome\",\"Artistic\"]', '[\"brown\",\"white\"]', 'Unleash your wild side with our Ivory Claw Press Ons! This fiercely fashionable set is a high-impact statement piece, blending an exotic print with an edgy, metallic finish. They are the perfect accessory for anyone who treats their nails like an extension of their wardrobe.\r\nThe design features a gorgeous, abstract ivory and dark brown animal print, creating a stunning, high-contrast texture. The nails are shaped into an aggressive, yet elegant stiletto for maximum drama. The ultimate detail is the metallic finish: a sleek, silver chrome tip reinforces the \"claw\" aesthetic, giving your fake nails a custom, high-fashion look.', '\"..\\/uploads\\/products\\/Ivory_Claw.webp\"', '[\"..\\/uploads\\/products\\/Ivory_Claw3.webp\",\"..\\/uploads\\/products\\/Ivory_Claw2.webp\",\"..\\/uploads\\/products\\/Ivory_Claw1.webp\"]', 0, 0),
(31, 'Whisspering Shadows', 58.00, '[\"Chrome\",\"3D\",\"Artistic\"]', '[\"black\",\"silver\",\"white\"]', 'Embrace your inner dark academic with our Whispering Shadows Press Ons. This set is a masterclass in the Gothic Coquette aesthetic, blending moody, mysterious tones with ultra-feminine details. If you’re looking for a reusable manicure that feels like a custom salon set from a boutique in Portland or Boston, this is your new obsession.\r\n\r\nSmoky Aura Centers: A delicate white base that fades into a deep, airbrushed black \"shadow\" at the center of each nail.\r\nHand-Sculpted 3D Art: Intricate 3D black floral charms with metallic silver centers that provide a tactile, high-end feel.\r\nBow & Pearl Accents: Dainty silver 3D ribbon bows finished with elegant white pearls for that perfect coquette touch.\r\nEthereal Linework: Sweeping silver abstract swirls and tiny star details that add a touch of cosmic magic to the dark palette.', '\"..\\/uploads\\/products\\/Whispering_Shadows.webp\"', '[\"..\\/uploads\\/products\\/Whispering_Shadows2.webp\",\"..\\/uploads\\/products\\/Whispering_Shadows1.webp\"]', 0, 0),
(32, 'Silver Starry Night', 42.00, '[\"Cateye\"]', '[\"black\",\"silver\"]', 'Step into the night with Silver Starry Night, a set of handmade press on nails that captures the magic of a starlit sky.\r\nEach nail features shimmering silver stars dancing across a deep black base — elegant, bold, and irresistibly glamorous.Perfect for those who love celestial vibes or want a statement look for parties, New Year’s Eve, or nights out.\r\nWith their smooth cat-eye shimmer and durable finish, these luxury reusable nails make every move sparkle like a star.', '\"..\\/uploads\\/products\\/Silver_Starry_Night.webp\"', '[\"..\\/uploads\\/products\\/Silver_Starry_Night_2.webp\",\"..\\/uploads\\/products\\/Silver_Starry_Night_1.webp\"]', 0, 0),
(33, 'Emeral Cosmos', 40.00, '[\"Cateye\",\"French Tip\",\"Artistic\"]', '[\"gold\",\"green\",\"neutral\",\"white\"]', 'This set of press-on nails combines the mystical allure of forest green with the softness of nude pink, enhanced by delicate golden moon and star accents to create a celestial and romantic look. The marble textures add a natural yet artistic touch, making these nails suitable for both everyday elegance and special occasions.\r\nEasy to apply and durable, it’s the perfect choice for those who want personalized, effortless beauty.', '\"..\\/uploads\\/products\\/Emerald_Cosmos.webp\"', '[\"..\\/uploads\\/products\\/Emerald_Cosmos2.webp\",\"..\\/uploads\\/products\\/Emerald_Cosmos1.webp\"]', 0, 0),
(36, 'Amber Wild', 46.00, '[\"Flower\",\"French Tip\",\"3D\"]', '[\"brown\",\"neutral\"]', 'This handmade press-on nail set features a soft nude base with leopard French tips, exuding chic wildness. Amber-toned nails embellished with golden rose charms bring a hint of luxury, while 3D sculpted flowers add depth and artistry.', '\"..\\/uploads\\/products\\/amber_wild.webp\"', '[\"..\\/uploads\\/products\\/amber_wild2.webp\",\"..\\/uploads\\/products\\/amber_wild1.webp\"]', 0, 0),
(38, 'Midnight Blossom', 58.00, '[\"Flower\",\"French Tip\",\"3D\"]', '[\"blue\",\"neutral\",\"white\"]', 'Step out with a touch of mysterious elegance in our Midnight Blossom Press Ons! This exquisite set takes the timeless class of a French manicure and gives it a sophisticated, moody twist, perfect for those who love Goth Glam or high-detail, artistic nails.The foundation is a flawlessly executed classic French tip on a milky nude base. The drama comes from the intricate, hand-sculpted details: each accent nail features stunning dark blue 3D flowers that look almost velvet, beautifully contrasted with lighter blue petals and tiny pearl centers. The design is artfully placed to enhance the elegant almond shape, creating a look that is both delicate and powerfully sophisticated.', '\"..\\/uploads\\/products\\/Midnight_Blossom.webp\"', '[\"..\\/uploads\\/products\\/Midnight_Blossom2.webp\",\"..\\/uploads\\/products\\/Midnight_Blossom1.webp\"]', 0, 0),
(39, 'Wine Bloom', 44.00, '[\"Flower\",\"3D\",\"Artistic\"]', '[\"burgundy\",\"neutral\"]', 'Indulge in the intoxicating elegance of Wine Bloom. This isn’t just a manicure—it’s a vintage-inspired masterpiece designed for the woman who loves a touch of drama and a lot of luxury.\r\n\r\nInspired by the deep, complex hues of a fine Cabernet, this set features a stunning hand-painted marble \"bloom\" effect that mimics wisps of silk in wine. We’ve accented the rich burgundy base with hand-sculpted 3D gold chrome and delicate celestial starbursts, creating a look that is both mystical and undeniably sophisticated. The addition of crocodile-textured tips adds a modern, high-fashion edge that screams runway-ready.', '\"..\\/uploads\\/products\\/Wine_Bloom.webp\"', '[\"..\\/uploads\\/products\\/Wine_Bloom2.webp\",\"..\\/uploads\\/products\\/Wine_Bloom1.webp\"]', 0, 0),
(40, 'Ocean Whisper', 46.00, '[\"Cute\",\"Flower\",\"3D\"]', '[\"blue\",\"pink\",\"yellow\",\"pastel\"]', 'Carry the serenity of the sea on your fingertips. The Ocean Whisper set is a love letter to the ocean, captured in a dreamy palette of seafoam blue and sunset pink. Designed for the modern mermaid, this set blends ethereal gradients with intricate, handcrafted 3D art that looks like it was plucked straight from a coral reef.\r\n\r\nEvery nail is a miniature treasure. We’ve combined sculpted 3D seashells, blooming aquatic flowers, and delicate pearl accents with tiny golden starfish to create a tactile, multi-dimensional masterpiece. Whether you’re planning a beach wedding, a tropical getaway, or just want to embrace your inner coastal \"soft girl,\" these nails are your ultimate summer escape.', '\"..\\/uploads\\/products\\/Ocean_Whisper.webp\"', '[\"..\\/uploads\\/products\\/Ocean_Whisper_2.webp\",\"..\\/uploads\\/products\\/Ocean_Whisper_1.webp\"]', 0, 0),
(41, 'Noir Bloom', 44.00, '[\"Flower\",\"French Tip\",\"3D\"]', '[\"black\",\"neutral\"]', 'Sophistication with a dark edge. The Noir Bloom collection is where timeless French elegance meets modern gothic romance. This set is designed for the woman who loves a classic look but demands a high-fashion, custom-crafted twist.\r\n\r\nStarting with a seamless sheer nude base, we’ve engineered a deep obsidian black French tip that elongates the fingers for a sleek, editorial silhouette. The focal point is our hand-sculpted 3D porcelain-white flowers that bloom across the nails, accented with delicate golden stamens. To finish the look, we’ve added hand-painted 24K-style gold leaf swirls and shimmering micro-pearls, providing a tactile, multi-dimensional finish that captures the light with every move.', '\"..\\/uploads\\/products\\/Noir_Bloom.webp\"', '[\"..\\/uploads\\/products\\/Noir_Bloom2.webp\",\"..\\/uploads\\/products\\/Noir_Bloom1.webp\"]', 0, 0),
(42, 'Crimson Bloom', 55.00, '[\"Flower\",\"3D\",\"Artistic\",\"Featured\"]', '[\"burgundy\",\"multicolor\"]', 'A masterpiece of dark romance. The Crimson Bloom collection is where high-fashion artistry meets the mysterious allure of a midnight garden. This isn\'t just a set of nails; it’s a bespoke accessory for the woman who commands attention with grace and intensity.\r\n\r\nStarting with a luxurious nude and deep burgundy base, we’ve integrated a stunning charcoal smoke gradient that mimics the ethereal flow of ink in water. The crowning glory of this set is the oversized 3D porcelain-style flowers, each petal hand-sculpted to perfection and centered with shimmering gold hardware and micro-pearls. These are paired with sleek French V-tips and delicate white hand-painted floral accents, creating a multi-layered, editorial look that belongs on the front cover of a magazine.', '\"..\\/uploads\\/products\\/Crimson_Bloom.webp\"', '[\"..\\/uploads\\/products\\/Crimson_Bloom_2.webp\",\"..\\/uploads\\/products\\/Crimson_Bloom_1.webp\"]', 0, 0),
(43, 'Floral Magic', 55.00, '[\"Cute\",\"Flower\",\"3D\",\"Artistic\",\"Featured\"]', '[\"blue\",\"pink\",\"pastel\"]', 'Step into a living dream. ✨🌸🦋\r\n\r\nThe Floral Magic set is an iridescent masterpiece designed for those who believe in everyday enchantment. We’ve layered opalescent aurora chrome with soft, watercolor washes of pink and sky blue to create a base that shifts color with every flick of your wrist. It’s a sensory experience at your fingertips.\r\n\r\nThis set is a playground of textures: featuring hand-sculpted 3D crystal blooms that catch the light like dew-covered morning petals, and translucent iridescent butterflies that look ready to take flight. Accented with floating pearls and holographic droplets, these nails bring a high-fashion \"Mermaidcore\" aesthetic to your daily rotation. Why settle for flat color when you can wear a 3D prism?', '\"..\\/uploads\\/products\\/Floral_Magic.webp\"', '[]', 0, 0),
(44, 'Wild Bloom', 44.00, '[\"3D\",\"Artistic\"]', '[\"gold\",\"burgundy\"]', 'Unleash your untamed side with a touch of gilded sophistication.\r\n\r\nThe Wild Bloom collection is where raw nature meets high-fashion artistry. We’ve moved beyond basic patterns to create a multi-dimensional aesthetic that’s as bold as a midnight safari. Featuring a rich, moody burgundy aura base, this set is elevated by hand-painted organic leopard-inspired spot textures and fluid 3D molten gold chrome accents that curve across the nail like liquid sunlight.\r\n\r\nThe centerpiece? A striking golden celestial starburst charm that adds an element of cosmic luxury to the earthy, wild vibes. Perfect for the woman who leads the pack, these nails are a masterclass in contrasting textures—from the soft gradient \"blush\" effect to the hard-edge brilliance of metallic hardware. It\'s an entire mood, crafted for the boldest version of you.', '\"..\\/uploads\\/products\\/Wild_Bloom.webp\"', '[\"..\\/uploads\\/products\\/Wild_Bloom2.webp\",\"..\\/uploads\\/products\\/Wild_Bloom1.webp\"]', 0, 0),
(45, 'Tropical Bloom', 44.00, '[\"Cute\",\"Flower\",\"3D\",\"Artistic\"]', '[\"multicolor\",\"pastel\"]', 'Your permanent vacation starts at your fingertips. The Tropical Bloom set is an explosive celebration of island life, meticulously crafted to bring the vibrant energy of a Pacific paradise to your everyday style. No plane ticket required—just apply and glow.\r\n\r\nThis set is a curated masterpiece of coastal textures. We’ve combined hand-painted hibiscus blooms in electric pinks and blues with sculpted 3D seashells that catch the light at every angle. For a touch of the unexpected, we’ve included a stunning green sea turtle motif and hyper-realistic 3D water droplets that look like you just stepped out of the turquoise surf. It’s bold, it’s intricate, and it’s the ultimate accessory for your next resort getaway.', '\"..\\/uploads\\/products\\/Tropical_Bloom.webp\"', '[\"..\\/uploads\\/products\\/Tropical_Bloom_3.webp\",\"..\\/uploads\\/products\\/Tropical_Bloom_1.webp\"]', 0, 0),
(46, 'Pure Pearl', 35.00, '[\"Pearl Aura\",\"Minimalist\"]', '[\"white\"]', 'Clean, timeless, and effortlessly elegant — meet Pure Pearl, a luminous set of press on nails that captures the soft glow of real pearls.\r\nHandcrafted with a natural white base and subtle iridescent sheen, these nails deliver a polished, luxurious finish that suits any occasion — from weddings and brunch dates to everyday wear.\r\nDesigned for those who adore minimal white nails, pearl shimmer nails, or luxury handmade press ons, Pure Pearl adds that final touch of sophistication that never goes unnoticed.', '\"..\\/uploads\\/products\\/Pure_Pearl.webp\"', '[\"..\\/uploads\\/products\\/Pure_Pearl_3.webp\",\"..\\/uploads\\/products\\/Pure_Pearl_2.webp\",\"..\\/uploads\\/products\\/Pure_Pearl_1.webp\"]', 0, 0),
(47, 'Rose Mist', 35.00, '[\"Pearl Aura\",\"Minimalist\"]', '[\"neutral\"]', 'Step into soft elegance with Rose Mist, a dreamy press on nail set designed for those who love subtle beauty and timeless charm.\r\nThis delicate blush pink shade captures the essence of romance — gentle, fresh, and endlessly wearable. Each set is handcrafted to perfection, giving you a natural, salon-quality look without ever stepping foot in a salon.', '\"..\\/uploads\\/products\\/Rose_Mist.webp\"', '[\"..\\/uploads\\/products\\/Rose_Mist_3.webp\",\"..\\/uploads\\/products\\/Rose_Mist_2.webp\",\"..\\/uploads\\/products\\/Rose_Mist_1.webp\"]', 0, 0),
(48, 'Cocoa Satin', 35.00, '[\"Pearl Aura\",\"Minimalist\"]', '[\"brown\"]', 'Handcrafted in a soft cocoa nude tone with a smooth, satin-like gloss, this set blends warmth and sophistication for a timeless, effortless look. Whether you’re heading to brunch, work, or a cozy night out, Cocoa Satin complements every outfit with its chic, understated charm.', '\"..\\/uploads\\/products\\/Cocoa_Satin.webp\"', '[\"..\\/uploads\\/products\\/Cocoa_Satin_3.webp\",\"..\\/uploads\\/products\\/Cocoa_Satin_2.webp\"]', 0, 0),
(49, 'Sage Glow', 35.00, '[\"Pearl Aura\",\"Minimalist\"]', '[\"green\"]', 'Your Official Manicure for Sweater Weather!\r\nMeet \"Sage Glow,\" the color that defines cozy sophistication this season. This set captures the serene, earthy mood of autumn in a single, flawless manicure. It\'s the perfect finishing touch for crisp morning walks, warm lattes, and every moment in between.\r\nWe’ve bottled the perfect, muted sage green and infused it with a subtle, pearlescent shimmer that catches the light for a soft, lit-from-within glow. This isn\'t a flat color; it has dimension and warmth that feels both organic and luxurious. More refined than typical fall shades, \"Sage Glow\" is the new neutral that effortlessly complements your autumn wardrobe, from chunky knits to tailored coats.', '\"..\\/uploads\\/products\\/Sage_Glow.webp\"', '[\"..\\/uploads\\/products\\/Sage_Glow2.webp\",\"..\\/uploads\\/products\\/Sage_Glow1.webp\"]', 0, 0),
(50, 'Pearl Whisper', 38.00, '[\"Pearl Aura\",\"French Tip\",\"Minimalist\"]', '[\"neutral\",\"pink\"]', 'Pearl Whisper Press On Nails Handmade Pink Pearl Finish\r\nSoft, elegant, and timeless — Pearl Whisper handmade press on nails bring a subtle pearly sheen to your fingertips. With their delicate blush pink base and natural glossy finish, this set delivers the perfect balance of minimalist press on nails and everyday sophistication.\r\nWhether you’re heading to work, a wedding, or simply love nude nails with a pearl effect, these handmade press on nails give you a salon-quality look in minutes. Lightweight, reusable, and effortless to apply, they’re designed for women who want beauty with ease.', '\"..\\/uploads\\/products\\/Pearl_Whisper.webp\"', '[\"..\\/uploads\\/products\\/Pearl_Whisper2.webp\",\"..\\/uploads\\/products\\/Pearl_Whisper1.webp\"]', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL COMMENT 'user id',
  `review_image` varchar(255) NOT NULL,
  `review_text` varchar(200) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `ratings` tinyint(3) UNSIGNED NOT NULL,
  `review_title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `id`, `review_image`, `review_text`, `date`, `ratings`, `review_title`) VALUES
(1, 19, '\"..\\/uploads\\/rating\\/e1fd55f2-9460-4124-b473-dbe650418801.jpg\"', 'Absolutely obsessed with these burgundy nail extensions — glossy, classy, and just that girl. The shape and length are perfect, and the colour looks expensive in every light.\r\n\r\nHuge shoutout to Rob 🫶', '2026-02-09', 5, 'Love my Burrrgundy!'),
(2, 20, '\"..\\/uploads\\/rating\\/09a1920e-906d-45ee-b8eb-5180b6164581.jpg\"', 'Had these on for a full month over summer and I’m genuinely impressed. I went to multiple beaches, swimming, sun, and sand, and they’re still fully intact. No lifting, no popping off, and they looked ', '2026-02-09', 5, 'Beach-tested & still standing'),
(3, 22, '\"..\\/uploads\\/rating\\/578768900_1374883181011179_6418702394680532950_n.jpg\"', 'Amazing service from start to finish ✨ Super friendly, took the time to make sure everything was exactly how I wanted, and the attention to detail was unreal. The whole experience felt so professional', '2026-02-09', 5, 'Relaxing Experience with Stunning Nails'),
(4, 26, '\"..\\/uploads\\/rating\\/e767302d-cee9-4558-aab7-521f9f4f6339.jpg\"', 'My friends are loyal Nail Utopia customers and they convinced me to try a set. Now I understand why they love it so much. The nails look amazing and the designs are super trendy', '2026-03-01', 5, 'I’m Officially a Nail Utopia Girl');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `user_type` enum('user','admin','staff','') NOT NULL DEFAULT 'user',
  `date_registered` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`id`, `fname`, `lname`, `email`, `pass`, `birthday`, `user_type`, `date_registered`) VALUES
(10, 'Sophia Grace', 'Bennet', 'admin1@gmail.com', '87ac90ef6f4495fc12b85d48f92a076b', '1998-10-26', 'admin', '2026-02-05'),
(11, 'Olivia', 'Carter', 'user1@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2006-05-03', 'user', '2026-02-05'),
(12, 'Charlotte', 'Williams', 'user2@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2005-04-04', 'user', '2026-02-05'),
(13, 'Ava', 'Mitchell', 'user3@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '1997-12-28', 'user', '2026-02-05'),
(15, 'Ruby', 'Scott', 'admin2@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2004-06-11', 'staff', '2026-02-05'),
(16, 'Millie', 'Walker', 'user5@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2005-04-01', 'user', '2026-02-05'),
(17, 'Kathryn', 'Bernardo', 'user6@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2001-05-10', 'user', '2026-02-05'),
(18, 'Madison', 'Reed', 'user7@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2003-06-08', 'user', '2026-02-05'),
(19, 'Clarisse', 'Parker', 'user8@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2003-12-31', 'user', '2026-02-05'),
(20, 'Avery', 'Brooks', 'user9@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2006-08-15', 'user', '2026-02-05'),
(23, 'Isla', 'Robertson', 'user12@gmail.com', '62a8248b5b7dbb9172a8f382b3cc5430', '2006-11-09', 'user', '2026-02-05'),
(26, 'Olivia', 'Hughes', 'user10@gmail.com', '6105a00c677b5b168cc1d7a0e8f9fba1', '1998-03-15', 'user', '2026-03-01'),
(28, 'Ari', 'Patterson', 'a.patterson@gmail.com', 'd6f7da8bb37152d77035ddc8bcd9ef47', '2005-04-24', 'user', '2026-03-02'),
(29, 'raven', 'mortega', '20351408@myclyde.ac.uk', '09f1b7b11e45505ca39382257a696ef1', '2003-04-19', 'admin', '2026-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `user_custom_set`
--

CREATE TABLE `user_custom_set` (
  `set_id` int(11) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL COMMENT 'user_id',
  `preference_id` int(11) UNSIGNED NOT NULL,
  `set_name` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_custom_set`
--

INSERT INTO `user_custom_set` (`set_id`, `id`, `preference_id`, `set_name`, `is_default`) VALUES
(38, 11, 53, 'Everyday Set', 1),
(39, 12, 54, 'Birthday Nails', 1),
(41, 19, 56, '', 1),
(45, 16, 60, 'Everyday', 1),
(47, 16, 62, 'Night out', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_custom_sizes`
--

CREATE TABLE `user_custom_sizes` (
  `custom_size_id` int(11) UNSIGNED NOT NULL,
  `id` int(11) NOT NULL,
  `set_id` int(11) DEFAULT NULL,
  `r_thumb` int(11) NOT NULL,
  `r_index` int(11) NOT NULL,
  `r_middle` int(11) NOT NULL,
  `r_ring` int(11) NOT NULL,
  `r_pinky` int(11) NOT NULL,
  `l_thumb` int(11) NOT NULL,
  `l_index` int(11) NOT NULL,
  `l_middle` int(11) NOT NULL,
  `l_ring` int(11) NOT NULL,
  `l_pinky` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_custom_sizes`
--

INSERT INTO `user_custom_sizes` (`custom_size_id`, `id`, `set_id`, `r_thumb`, `r_index`, `r_middle`, `r_ring`, `r_pinky`, `l_thumb`, `l_index`, `l_middle`, `l_ring`, `l_pinky`) VALUES
(17, 11, NULL, 16, 13, 12, 13, 9, 16, 13, 12, 12, 9),
(18, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(19, 12, 39, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(20, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(21, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(22, 20, NULL, 14, 12, 11, 12, 9, 14, 12, 11, 12, 9),
(23, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(24, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(25, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8),
(26, 12, NULL, 14, 10, 9, 10, 8, 14, 10, 9, 10, 8);

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `voucher_id` int(11) UNSIGNED NOT NULL,
  `voucher_code` varchar(200) NOT NULL,
  `voucher_discount` tinyint(3) UNSIGNED NOT NULL,
  `start_at` date NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `voucher_type` enum('registered','all','birthday') NOT NULL,
  `min_order` decimal(10,2) DEFAULT 20.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`voucher_id`, `voucher_code`, `voucher_discount`, `start_at`, `expires_at`, `created_at`, `voucher_type`, `min_order`) VALUES
(1, 'NEWUSER2026', 15, '2026-01-01', NULL, '2026-01-01 00:00:00', '', 20.00),
(2, 'NAILBFFS', 10, '2026-03-05', '2028-12-31 23:59:59', '2026-03-03 00:00:00', 'all', 20.00),
(5, 'BDAY26', 15, '2026-03-05', '2027-01-01 23:59:59', '2026-03-05 22:47:49', 'birthday', 20.00),
(6, 'VALENTINES', 14, '2026-02-01', '2026-02-28 23:25:36', '2026-01-31 23:25:36', 'all', 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `voucher_claim`
--

CREATE TABLE `voucher_claim` (
  `claim_id` int(10) UNSIGNED NOT NULL,
  `voucher_id` int(10) UNSIGNED NOT NULL,
  `id` int(11) DEFAULT NULL COMMENT 'user id',
  `session_id` varchar(200) DEFAULT NULL,
  `claim_status` enum('claimed','applied','removed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `voucher_claim`
--

INSERT INTO `voucher_claim` (`claim_id`, `voucher_id`, `id`, `session_id`, `claim_status`) VALUES
(27, 1, 19, NULL, 'claimed'),
(38, 2, 19, NULL, 'claimed'),
(40, 1, 12, NULL, 'claimed'),
(41, 2, 12, NULL, 'claimed'),
(42, 1, 16, NULL, 'claimed'),
(43, 2, 16, NULL, 'applied');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD UNIQUE KEY `id` (`id`,`line_1`,`postcode`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_items_ibfk_1` (`cart_id`),
  ADD KEY `cart_items_ibfk_2` (`prod_id`),
  ADD KEY `custom_size_id` (`custom_size_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`newsletter_id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `open_hours`
--
ALTER TABLE `open_hours`
  ADD PRIMARY KEY (`hours_id`),
  ADD UNIQUE KEY `day_of_week` (`day_of_week`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number_2` (`order_number`,`cart_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `pov`
--
ALTER TABLE `pov`
  ADD PRIMARY KEY (`pov_id`),
  ADD KEY `fk_pov_user` (`user_id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`preference_id`);

--
-- Indexes for table `press_on`
--
ALTER TABLE `press_on`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_custom_set`
--
ALTER TABLE `user_custom_set`
  ADD PRIMARY KEY (`set_id`),
  ADD KEY `id` (`id`),
  ADD KEY `preference_id` (`preference_id`);

--
-- Indexes for table `user_custom_sizes`
--
ALTER TABLE `user_custom_sizes`
  ADD PRIMARY KEY (`custom_size_id`),
  ADD KEY `set_id` (`set_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`voucher_id`),
  ADD UNIQUE KEY `voucher_code` (`voucher_code`);

--
-- Indexes for table `voucher_claim`
--
ALTER TABLE `voucher_claim`
  ADD PRIMARY KEY (`claim_id`),
  ADD UNIQUE KEY `voucher_id_2` (`voucher_id`,`id`),
  ADD UNIQUE KEY `voucher_id_3` (`voucher_id`,`session_id`),
  ADD KEY `id` (`id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `newsletter_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `open_hours`
--
ALTER TABLE `open_hours`
  MODIFY `hours_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pov`
--
ALTER TABLE `pov`
  MODIFY `pov_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `preference_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `press_on`
--
ALTER TABLE `press_on`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_custom_set`
--
ALTER TABLE `user_custom_set`
  MODIFY `set_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `user_custom_sizes`
--
ALTER TABLE `user_custom_sizes`
  MODIFY `custom_size_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `voucher_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `voucher_claim`
--
ALTER TABLE `voucher_claim`
  MODIFY `claim_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`id`) REFERENCES `userlogin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id`) REFERENCES `userlogin` (`id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `press_on` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`custom_size_id`) REFERENCES `user_custom_sizes` (`custom_size_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD CONSTRAINT `newsletter_ibfk_1` FOREIGN KEY (`id`) REFERENCES `userlogin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pov`
--
ALTER TABLE `pov`
  ADD CONSTRAINT `fk_pov_user` FOREIGN KEY (`user_id`) REFERENCES `userlogin` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
