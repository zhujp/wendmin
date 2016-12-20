-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2016-12-19 12:30:09
-- 服务器版本： 5.7.11
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `www_wendiy_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `w_articles`
--

CREATE TABLE `w_articles` (
  `id` int(11) NOT NULL,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `author` varchar(60) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `intro` varchar(255) NOT NULL DEFAULT '',
  `body` text,
  `views` smallint(6) NOT NULL DEFAULT '0',
  `collects` smallint(6) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_articles`
--

INSERT INTO `w_articles` (`id`, `manager_id`, `author`, `title`, `intro`, `body`, `views`, `collects`, `disabled`, `created_at`, `updated_at`) VALUES
(2, 24, '就在', '我是大克利夫兰的', '氮磷钾肥带来了发动机   ', '对方江东父老的劳动纠纷来得及浪费了的风急浪大短发短发  ', 0, 0, 0, 1480003200, 1480510935);

-- --------------------------------------------------------

--
-- 表的结构 `w_auth_access`
--

CREATE TABLE `w_auth_access` (
  `id` int(11) NOT NULL,
  `app` varchar(40) NOT NULL DEFAULT '',
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `group_id` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_auth_access`
--

INSERT INTO `w_auth_access` (`id`, `app`, `manager_id`, `group_id`) VALUES
(3, 'admin', 24, 1);

-- --------------------------------------------------------

--
-- 表的结构 `w_auth_group`
--

CREATE TABLE `w_auth_group` (
  `id` smallint(6) NOT NULL,
  `app` varchar(40) NOT NULL DEFAULT '',
  `group_name` varchar(100) NOT NULL DEFAULT '',
  `intro` varchar(255) NOT NULL DEFAULT '',
  `rules` text,
  `disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_auth_group`
--

INSERT INTO `w_auth_group` (`id`, `app`, `group_name`, `intro`, `rules`, `disabled`) VALUES
(1, 'admin', '老板', '究极权限', '1,2,3,17,4', 0);

-- --------------------------------------------------------

--
-- 表的结构 `w_auth_rules`
--

CREATE TABLE `w_auth_rules` (
  `id` int(11) NOT NULL,
  `app` varchar(40) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_auth_rules`
--

INSERT INTO `w_auth_rules` (`id`, `app`, `type`, `name`, `title`, `disabled`) VALUES
(1, 'admin', 0, 'admin/index/index', '主页', 0),
(2, 'admin', 0, 'admin/user/index', '用户', 0),
(3, 'admin', 1, 'admin/user/index', '用户列表', 0),
(4, 'admin', 0, 'admin/article/index', '内容', 0),
(5, 'admin', 1, 'admin/article/index', '文章列表', 0),
(11, 'admin', 1, 'admin/menu/index', '菜单列表', 0),
(12, 'admin', 1, 'admin/manager/index', '管理员列表', 0),
(13, 'admin', 1, 'admin/auth/create', '新增权限组', 0),
(14, 'admin', 1, 'admin/setting/index', '系统设置', 0),
(15, 'admin', 0, 'admin/menu/index', '系统', 0),
(16, 'admin', 1, 'admin/menu/create', '新增菜单', 0),
(17, 'admin', 1, 'admin/user/destory', '删除用户', 0),
(18, 'admin', 1, 'admin/user/create', '新增用户', 0),
(19, 'admin', 1, 'admin/user/edit', '编辑用户', 0),
(20, 'admin', 1, 'admin/article/create', '新增文章', 0),
(21, 'admin', 1, 'admin/article/edit', '编辑文章', 0),
(22, 'admin', 1, 'admin/article/destory', '删除文章', 0),
(26, 'admin', 1, 'admin/menu/edit', '编辑菜单', 0),
(27, 'admin', 1, 'admin/menu/destory', '删除菜单', 0),
(28, 'admin', 1, 'admin/manager/create', '新增管理员', 0),
(29, 'admin', 1, 'admin/manager/edit', '编辑管理员', 0),
(30, 'admin', 1, 'admin/manager/destory', '删除管理员', 0),
(31, 'admin', 1, 'admin/auth/index', '新增权限', 0),
(32, 'admin', 1, 'admin/auth/edit', '编辑权限组', 0),
(33, 'admin', 1, 'admin/auth/destory', '删除权限组', 0),
(34, 'admin', 1, 'admin/auth/access', '访问授权', 0),
(35, 'admin', 1, 'admin/auth/user', '用户授权', 0);

-- --------------------------------------------------------

--
-- 表的结构 `w_managers`
--

CREATE TABLE `w_managers` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_managers`
--

INSERT INTO `w_managers` (`id`, `username`, `mobile`, `email`, `password`, `disabled`, `last_login`, `created_at`, `updated_at`) VALUES
(24, 'admin', '15669732593', 'admin@admi33n.com', '$2y$10$25df4L4nND9TS4qhvTAhiOvz4RINQYbqIT/A87o1u77BCs1GSVgsS', 0, 0, 1479908415, 1482053792);

-- --------------------------------------------------------

--
-- 表的结构 `w_menu`
--

CREATE TABLE `w_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL DEFAULT '',
  `url` varchar(60) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `path_str` varchar(255) NOT NULL DEFAULT '',
  `disabled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_menu`
--

INSERT INTO `w_menu` (`id`, `name`, `url`, `parent_id`, `sort`, `path_str`, `disabled`) VALUES
(21, '主页', 'index/index', 0, 1, '', 0),
(22, '用户', 'user/index', 0, 2, '', 0),
(23, '用户列表', 'user/index', 22, 1, '22,', 0),
(24, '内容', 'article/index', 0, 3, '', 0),
(25, '文章列表', 'article/index', 24, 1, '24,', 0),
(26, '系统', 'menu/index', 0, 10, '', 0),
(27, '系统设置', 'setting/index', 26, 10, '26,', 0),
(28, '权限管理', 'auth/index', 26, 8, '26,', 0),
(29, '管理员列表', 'manager/index', 26, 6, '26,', 0),
(30, '菜单列表', 'menu/index', 26, 4, '26,', 0),
(31, '新增菜单', 'menu/create', 30, 1, '26,,30', 0),
(32, '删除用户', 'user/destory', 23, 3, '22,,23', 0),
(33, '新增用户', 'user/create', 23, 1, '22,,23', 0),
(34, '编辑用户', 'user/edit', 23, 2, '22,,23', 0),
(35, '新增文章', 'article/create', 25, 1, '24,,25', 0),
(36, '编辑文章', 'article/edit', 25, 2, '24,,25', 0),
(37, '删除文章', 'article/destory', 25, 2, '24,,25', 0),
(38, '编辑菜单', 'menu/edit', 30, 2, '26,,30', 0),
(39, '删除菜单', 'menu/destory', 30, 3, '26,,30', 0),
(40, '新增管理员', 'manager/create', 29, 1, '26,,29', 0),
(41, '编辑管理员', 'manager/edit', 29, 2, '26,,29', 0),
(42, '删除管理员', 'manager/destory', 29, 3, '26,,29', 0),
(43, '新增权限组', 'auth/create', 28, 1, '26,,28', 0),
(44, '编辑权限组', 'auth/edit', 28, 2, '26,,28', 0),
(45, '删除权限组', 'auth/destory', 28, 3, '26,,28', 0),
(46, '访问授权', 'auth/access', 28, 4, '26,,28', 0),
(47, '用户授权', 'auth/user', 28, 5, '26,,28', 0);

-- --------------------------------------------------------

--
-- 表的结构 `w_setting`
--

CREATE TABLE `w_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `intro` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `sort` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('radio','text','textarea','checkbox','select','img') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `w_setting`
--

INSERT INTO `w_setting` (`id`, `name`, `value`, `intro`, `title`, `sort`, `type`) VALUES
(1, 'web_site', 'Wendiy', '', '站点设置', 1, 'text'),
(2, 'web_keyword', '我是Wendiy', '', '站点介绍', 2, 'textarea'),
(3, 'logo', 'http://z.wendiy.com/uploads/20161218/e9685c04bf7396ca127387b1d90dfb6e.jpg', '', 'Logo', 3, 'img');

-- --------------------------------------------------------

--
-- 表的结构 `w_users`
--

CREATE TABLE `w_users` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `age` smallint(6) NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `birthday` int(11) NOT NULL DEFAULT '0',
  `ip` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `w_articles`
--
ALTER TABLE `w_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_auth_access`
--
ALTER TABLE `w_auth_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_id` (`manager_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `w_auth_group`
--
ALTER TABLE `w_auth_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_auth_rules`
--
ALTER TABLE `w_auth_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_managers`
--
ALTER TABLE `w_managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_ind` (`username`),
  ADD KEY `email_ind` (`email`);

--
-- Indexes for table `w_menu`
--
ALTER TABLE `w_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_ind` (`name`),
  ADD KEY `url_ind` (`url`);

--
-- Indexes for table `w_setting`
--
ALTER TABLE `w_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `w_users`
--
ALTER TABLE `w_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_ind` (`username`),
  ADD KEY `email_ind` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `w_articles`
--
ALTER TABLE `w_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- 使用表AUTO_INCREMENT `w_auth_access`
--
ALTER TABLE `w_auth_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `w_auth_group`
--
ALTER TABLE `w_auth_group`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `w_auth_rules`
--
ALTER TABLE `w_auth_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- 使用表AUTO_INCREMENT `w_managers`
--
ALTER TABLE `w_managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- 使用表AUTO_INCREMENT `w_menu`
--
ALTER TABLE `w_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- 使用表AUTO_INCREMENT `w_setting`
--
ALTER TABLE `w_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `w_users`
--
ALTER TABLE `w_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- 限制导出的表
--

--
-- 限制表 `w_auth_access`
--
ALTER TABLE `w_auth_access`
  ADD CONSTRAINT `w_auth_access_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `w_managers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `w_auth_access_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `w_auth_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
