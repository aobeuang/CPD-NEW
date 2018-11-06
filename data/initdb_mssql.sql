USE [jaymart]





GO
/****** Object:  Table [dbo].[acl]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[acl](
    [ai] [bigint] IDENTITY(1,1) NOT NULL,
    [action_id] [bigint] NULL,
    [user_id] [bigint] NULL,
PRIMARY KEY CLUSTERED
(
    [ai] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]





GO
/****** Object:  Table [dbo].[acl_actions]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[acl_actions](
    [action_id] [bigint] IDENTITY(1,1) NOT NULL,
    [action_code] [nchar](100) NOT NULL,
    [action_desc] [nchar](100) NOT NULL,
    [category_id] [bigint] NOT NULL,
PRIMARY KEY CLUSTERED
(
    [action_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]






GO
/****** Object:  Table [dbo].[acl_categories]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[acl_categories](
    [category_id] [bigint] IDENTITY(1,1) NOT NULL,
    [category_code] [nchar](100) NOT NULL,
    [category_desc] [nchar](100) NOT NULL,
PRIMARY KEY CLUSTERED
(
    [category_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]






GO
/****** Object:  Table [dbo].[announcements]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[announcements](
    [announcement_id] [bigint] IDENTITY(1,1) NOT NULL,
    [message] [nchar](255) NOT NULL,
    [created_at] [datetime] NULL,
    [updated_at] [datetime] NULL,
PRIMARY KEY CLUSTERED
(
    [announcement_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]






GO
/****** Object:  Table [dbo].[auth_sessions]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[auth_sessions](
    [id] [nchar](40) NOT NULL,
    [user_id] [bigint] NOT NULL,
    [login_time] [datetime] NULL,
    [ip_address] [nchar](45) NULL,
    [user_agent] [nchar](60) NULL,
    [modified_at] [datetime] NULL
) ON [PRIMARY]






GO
/****** Object:  Table [dbo].[ci_sessions]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ci_sessions](
    [id] [nchar](40) NOT NULL,
    [ip_address] [nchar](45) NOT NULL,
    [timestamp] [bigint] NOT NULL,
    [data] [text] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]






GO
/****** Object:  Table [dbo].[denied_access]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[denied_access](
    [ai] [bigint] IDENTITY(1,1) NOT NULL,
    [ip_address] [nchar](45) NOT NULL,
    [time] [datetime] NOT NULL,
    [reason_code] [tinyint] NULL,
PRIMARY KEY CLUSTERED
(
    [ai] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]









GO
/****** Object:  Table [dbo].[ips_on_hold]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ips_on_hold](
    [ai] [bigint] IDENTITY(1,1) NOT NULL,
    [ip_address] [nchar](45) NOT NULL,
    [time] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED
(
    [ai] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]








GO
/****** Object:  Table [dbo].[login_errors]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[login_errors](
    [ai] [bigint] IDENTITY(1,1) NOT NULL,
    [username_or_email] [nchar](255) NOT NULL,
    [ip_address] [nchar](45) NOT NULL,
    [time] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED
(
    [ai] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]








GO
/****** Object:  Table [dbo].[username_or_email_on_hold]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[username_or_email_on_hold](
    [ai] [bigint] IDENTITY(1,1) NOT NULL,
    [username_or_email] [nchar](255) NOT NULL,
    [time] [datetime] NOT NULL,
PRIMARY KEY CLUSTERED
(
    [ai] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]





GO
/****** Object:  Table [dbo].[users]    Script Date: 9/25/2016 9:20:24 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[users](
    [user_id] [bigint] IDENTITY(1,1) NOT NULL,
    [username] [nchar](64) NULL,
    [name] [nchar](255) NOT NULL,
    [auth_level] [int] NOT NULL,
    [banned] [tinyint] NOT NULL,
    [passwd] [nchar](60) NOT NULL,
    [passwd_recovery_code] [varchar](60) NULL,
    [passwd_recovery_date] [datetime] NULL,
    [passwd_modified_at] [datetime] NULL,
    [last_login] [datetime] NULL,
    [created_at] [datetime] NULL,
    [modified_at] [datetime] NULL,
    [email] [nchar](64) NULL,
PRIMARY KEY CLUSTERED
(
    [user_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]






GO
/****** Object:  Table [dbo].[groups]     ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[groups](
    [group_id] [bigint] IDENTITY(1,1) NOT NULL,
    [name] [nchar](255) NOT NULL,
    [created_at] [datetime] NULL,
    [modified_at] [datetime] NULL,
    [deleted] [tinyint] NOT NULL,
PRIMARY KEY CLUSTERED
(
    [group_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]




GO
/****** Object:  Table [dbo].[user_group] ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[user_group](
    [user_group_id] [bigint] IDENTITY(1,1) NOT NULL,
    [user_id] [bigint] NOT NULL,
    [group_id] [bigint] NOT NULL, 
    [created_at] [datetime] NULL,
    [modified_at] [datetime] NULL,     
    [deleted] [tinyint]  NOT NULL,      
PRIMARY KEY CLUSTERED
(
    [user_group_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]






GO
/****** Object:  Table [dbo].[user_group] ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[workflows](
    [workflow_id] [bigint] IDENTITY(1,1) NOT NULL,
    [name] [nchar](255) NOT NULL,
    [description] [nchar](255) NOT NULL,
    [created_at] [datetime] NULL,
    [modified_at] [datetime] NULL,    
    [created_by] [bigint] NOT NULL,
    [modified_by] [bigint] NOT NULL,
    [group_id] [bigint] NOT NULL,    
    [deleted] [tinyint]  NOT NULL,    
PRIMARY KEY CLUSTERED
(
    [workflow_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]



GO
/****** Object:  Table [dbo].[workflow_status] ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[workflow_status](
    [workflow_status_id] [bigint] IDENTITY(1,1) NOT NULL,
    [workflow_id] [bigint] NOT NULL,
    [name] [nchar](255) NOT NULL,
    [description] [nchar](255) NOT NULL,
    [workflow_order] [int] NULL,
    [override_group_id] [int] NULL,
    [created_at] [datetime] NULL,
    [modified_at] [datetime] NULL,   
    [deleted] [tinyint]  NOT NULL,     
PRIMARY KEY CLUSTERED
(
    [workflow_status_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]


GO
/****** Object:  Table [dbo].[group_workflow_status] ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[group_workflow_status](
    [group_workflow_status_id] [bigint] IDENTITY(1,1) NOT NULL,
    [group_id] [bigint] NOT NULL,
    [workflow_status_id] [bigint] NOT NULL,
    [created_at] [datetime] NULL,
    [modified_at] [datetime] NULL,  
    [deleted] [tinyint]  NOT NULL,
PRIMARY KEY CLUSTERED
(
    [group_workflow_status_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]




GO
/****** Object:  Table [dbo].[notifications] ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[notifications](
    [notification_id] [bigint] IDENTITY(1,1) NOT NULL,
    [message] [nchar](255) NULL,
    [user_id] [bigint] NOT NULL,
    [created_by] [bigint] NOT NULL,
    [created_at] [datetime] NULL,
    [is_read] [tinyint] NULL,
PRIMARY KEY CLUSTERED
(
    [notification_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]



GO
/****** Object:  Table [dbo].[comments] ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[comments](
    [comment_id] [bigint] IDENTITY(1,1) NOT NULL,
    [message] [text] NULL,
    [user_id] [bigint] NOT NULL,
    [created_at] [datetime] NULL,
PRIMARY KEY CLUSTERED
(
    [comment_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]



/****** populate data constraints ******/



GO
SET ANSI_PADDING OFF
GO
ALTER TABLE [dbo].[announcements] ADD  CONSTRAINT [DF_announcements_created_at]  DEFAULT (NULL) FOR [created_at]
GO
ALTER TABLE [dbo].[announcements] ADD  CONSTRAINT [DF_announcements_updated_at]  DEFAULT (NULL) FOR [updated_at]
GO
ALTER TABLE [dbo].[auth_sessions] ADD  CONSTRAINT [DF_auth_sessions_login_time]  DEFAULT (getdate()) FOR [login_time]
GO
ALTER TABLE [dbo].[auth_sessions] ADD  CONSTRAINT [DF_auth_sessions_user_agent]  DEFAULT (NULL) FOR [user_agent]
GO
ALTER TABLE [dbo].[ci_sessions] ADD  CONSTRAINT [DF_ci_sesssions_timestamp]  DEFAULT ((0)) FOR [timestamp]
GO
ALTER TABLE [dbo].[denied_access] ADD  CONSTRAINT [DF_denied_access_reason_code]  DEFAULT ((0)) FOR [reason_code]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF_users_username]  DEFAULT (NULL) FOR [username]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF_users_banned]  DEFAULT ((0)) FOR [banned]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF_users_passwd_recovery_code]  DEFAULT (NULL) FOR [passwd_recovery_code]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF_users_passwd_recovery_date]  DEFAULT (NULL) FOR [passwd_recovery_date]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF_users_passwd_modified_at]  DEFAULT (NULL) FOR [passwd_modified_at]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF_users_last_login]  DEFAULT (NULL) FOR [last_login]
GO

ALTER TABLE [dbo].[workflow_status] ADD  CONSTRAINT [DF_workflow_status_deleted]  DEFAULT (0) FOR [deleted]
GO
ALTER TABLE [dbo].[group_workflow_status] ADD  CONSTRAINT [DF_group_workflow_status_deleted]  DEFAULT (0) FOR [deleted]
GO
ALTER TABLE [dbo].[groups] ADD  CONSTRAINT [DF_group_deleted]  DEFAULT (0) FOR [deleted]
GO
ALTER TABLE [dbo].[user_group] ADD  CONSTRAINT [DF_user_group_deleted]  DEFAULT (0) FOR [deleted]
GO
ALTER TABLE [dbo].[workflows] ADD  CONSTRAINT [DF_workflow_deleted]  DEFAULT (0) FOR [deleted]
GO










/****** populate data ******/

Insert into [dbo].[users](username,name,auth_level,banned,passwd,email) values ('admin', 'admin' ,9,0,  '$2y$11$WGzGp7nhIqy9uvqjEgFYnO94NfTZAdb1f9SMJmnydEUJE7/WKavuS', 'premw@hotmail.com');



