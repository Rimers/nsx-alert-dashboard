--
-- Table structure for table `vrli_alerts`
--

CREATE TABLE `vrli_alerts` (
  `id` int(13) NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vmw_nsxt_firewall_src` varchar(255) DEFAULT NULL,
  `reverse_src` varchar(255) NOT NULL,
  `vmw_nsxt_firewall_dst` varchar(255) DEFAULT NULL,
  `reverse_dst` varchar(255) NOT NULL,
  `vmw_nsx_firewall_protocol` varchar(255) DEFAULT NULL,
  `vmw_nsxt_firewall_action` varchar(255) DEFAULT NULL,
  `vmw_nsxt_firewall_dst_port` varchar(255) DEFAULT NULL,
  `vmw_nsxt_firewall_dst_ip_port` varchar(255) DEFAULT NULL,
  `logging_tag` varchar(255) NOT NULL,
  `logging_tcp_flags` varchar(255) NOT NULL,
  `alert_webhook_id` int(13) DEFAULT NULL,
  `alert_parent_id` int(13) DEFAULT NULL,
  `alert_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `alert_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `alert_status` enum('new','fixed','wait','duplicate') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `vrli_alerts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vrli_alerts`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;
COMMIT;



CREATE TABLE `vrli_webhook_inbound` (
  `id` int(13) NOT NULL,
  `data` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state` enum('new','fixed','skipped') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `vrli_webhook_inbound`
  ADD PRIMARY KEY (`id`);
  
ALTER TABLE `vrli_webhook_inbound`
  MODIFY `id` int(13) NOT NULL AUTO_INCREMENT;
COMMIT;
