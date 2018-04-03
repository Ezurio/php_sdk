/*
#
# Copyright (c) 2015, Laird
#
# Permission to use, copy, modify, and/or distribute this software for any
# purpose with or without fee is hereby granted, provided that the above
# copyright notice and this permission notice appear in all copies
# THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
# WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
# MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
# ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
# WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
# ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
# OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
#--------------------------------------------------------------------------*/

/* Please reference sdc_sdk.h for function definition and usage. */

%module lrd_php_sdk
%{
	#include "sdc_sdk.h"
	#include "lrd_sdk_eni.h"
%}
%include <carrays.i>
%include "cpointer.i"
%include "phppointers.i"
%include "cmalloc.i"
%pointer_functions( unsigned long, ulongp )
%pointer_functions( int, intp )
%pointer_functions( size_t, size_tp )
%pointer_functions( FCC_TEST, FCC_TESTp )
%pointer_functions( BITRATE, BITRATEp )
%pointer_functions( TXPOWER, TXPOWERp )
%pointer_functions( WEPLEN, WEPLENp )
%pointer_functions( CERTLOCATION, CERTLOCATIONp )
%pointer_functions( RADIOCHIPSET, RADIOCHIPSETp )
%pointer_functions( WF_SUPP_LOGLEVEL, WF_SUPP_LOGLEVELp )
%pointer_functions( LRD_WF_DRV_DEBUG, LRD_WF_DRV_DEBUGp )
%pointer_functions( SDCERR, SDCERRp )
%array_functions( unsigned char, uchar_array )
%array_functions( unsigned long, ulong_array )
%array_functions( SDCConfig, SDCConfig_array )
%nodefaultdtor _SDCConfig;
%free( SDCConfig );

%define ALLOCLIST(type,name)
%inline %{
type *new_ ## name (int *numEntries, SDCERR *ret) {
	SDCERR sdcError = SDCERR_FAIL;
	LRD_WF_BSSID_LIST *list = NULL;
	list = (LRD_WF_BSSID_LIST *) malloc(sizeof(LRD_WF_BSSID_LIST) + (sizeof(LRD_WF_SCAN_ITEM_INFO) * (*numEntries-1)));
	memset(list,0,sizeof(LRD_WF_BSSID_LIST) + (sizeof(LRD_WF_SCAN_ITEM_INFO) * (*numEntries-1)));
	sdcError = LRD_WF_GetBSSIDList(list, numEntries);
	*ret = sdcError;
	LRD_WF_SCAN_ITEM_INFO *item = NULL;
	item = malloc(sizeof(LRD_WF_SCAN_ITEM_INFO) * *numEntries);
	memcpy (item, list->Bssid, sizeof(LRD_WF_SCAN_ITEM_INFO) * *numEntries);
	free(list);
	return item;
}
type *name ## _get(type *list, int index) {
	LRD_WF_SCAN_ITEM_INFO *item = NULL;

	item = &list[index];

	return item;
}
void delete_ ## name(type *t) {
	free(t);
}
%}
%enddef

ALLOCLIST(LRD_WF_SCAN_ITEM_INFO,LRD_WF_PHP_GetBSSIDList)

%define ALLOCIPLIST(type,name)
%inline %{
type *new_ ## name (size_t *arr_size, SDCERR *ret) {
	SDCERR sdcError = SDCERR_FAIL;
	LRD_WF_ipv6names *ipnames = NULL;
	ipnames	= malloc(sizeof(LRD_WF_ipv6names) * *arr_size);
	sdcError = LRD_WF_GetIpV6Address(ipnames, arr_size);
	*ret = sdcError;
	return ipnames;

}
char *name ## _get(type *list, int index) {
	LRD_WF_ipv6names *ipnames = NULL;

	ipnames = &list[index];

	return (char *) ipnames;
}
void delete_ ## name(type *t) {
	free(t);
}
%}
%enddef

ALLOCIPLIST(LRD_WF_ipv6names,LRD_WF_PHP_GetIpV6Address)

#define LRD_PHP_SDK_BUILD_MAJOR 3
#define LRD_PHP_SDK_BUILD_MINOR 5
#define LRD_PHP_SDK_BUILD_REVISION 6
#define LRD_PHP_SDK_BUILD_SUB_REVISION 16

#define LRD_PHP_SDK_VERSION_MAJOR 3
#define LRD_PHP_SDK_VERSION_MINOR 5
#define LRD_PHP_SDK_VERSION_REVISION 2
#define LRD_PHP_VERSION_SUB_REVISION 0

#define CONFIG_NAME_SZ  33
#define SSID_SZ         33
#define CLIENT_NAME_SZ  17
#define MAC_AS_ASCII_SZ 18
#define USER_NAME_SZ    65
#define USER_PWD_SZ     65
#define PSK_SZ          65
#define MAX_CFGS        20
#define NUM_WEP_KEYS    4
#define MAC_ADDR_SZ     6
#define IPv4_ADDR_SZ    4
#define PDELAY_LOW      0
#define PDELAY_HIGH     7200000
#define PTIME_LOW       0
#define PTIME_HIGH      30000
#define BEACONMISSTIME_LOW      1000
#define BEACONMISSTIME_HIGH     5000
#define FRAG_LOW        256
#define FRAG_HIGH       2346
#define RTS_LOW         0
#define RTS_HIGH        2347
#define AUTH_LOW        3
#define AUTH_HIGH       60
#define PROBE_DELAY_LOW         2
#define PROBE_DELAY_HIGH      120
#define ROAM_DELTA_LOW          2
#define ROAM_DELTA_HIGH        55
#define ROAM_PERIOD_LOW         0
#define ROAM_PERIOD_HIGH       60
#define ROAM_PERIOD_MS_LOW     10
#define ROAM_PERIOD_MS_HIGH 60000
#define ROAM_TRIGGER_LOW       50
#define ROAM_TRIGGER_HIGH      90
#define SCANDFSTIME_LOW        20
#define SCANDFSTIME_HIGH      500
#define TX_MAX_LOW              0
#define TX_MAX_HIGH           100
#define MAX_CERT_PATH   65
#define CRED_CA_POS     72
#define CRED_UCA_POS    72
#define CRED_PFILE_POS  34
#define CRED_CERT_SZ    48
#define CRED_PFILE_SZ   32
#define USER_CERT_PW_SZ 64
#define LRS_MAX_CHAN	  32

#define LRD_ENI_ERROR_SUCCESS			0
#define LRD_ENI_ERROR_FAIL				1
#define LRD_ENI_PROPERTY_AUTO			"auto"
#define LRD_ENI_PROPERTY_DHCP			"dhcp"
#define LRD_ENI_PROPERTY_ADDRESS		"address"
#define LRD_ENI_PROPERTY_NETMASK		"netmask"
#define LRD_ENI_PROPERTY_GATEWAY		"gateway"
#define LRD_ENI_PROPERTY_BROADCAST		"broadcast"
#define LRD_ENI_PROPERTY_NAMESERVER		"nameserver"
#define LRD_ENI_PROPERTY_STATIC			"static"
#define LRD_ENI_PROPERTY_MANUAL			"manual"
#define LRD_ENI_PROPERTY_BRIDGEPORTS	"bridge_ports"
#define LRD_ENI_PROPERTY_STATE			"state"
#define LRD_ENI_PROPERTY_METHOD			"method"
#define LRD_ENI_PROPERTY_HOSTAPD		"hostapd"
#define LRD_ENI_PROPERTY_POSTUDHCPD		"post-cfg-do /etc/dhcp/udhcpd.sh"
#define LRD_ENI_PROPERTY_PREUDHCPD		"pre-dcfg-do /etc/dhcp/udhcpd.sh"

enum SDCERR {
	SDCERR_SUCCESS,
	SDCERR_FAIL,
	SDCERR_INVALID_NAME,
	SDCERR_INVALID_CONFIG,
	SDCERR_INVALID_DELETE,
	SDCERR_POWERCYCLE_REQUIRED,
	SDCERR_INVALID_PARAMETER,
	SDCERR_INVALID_EAP_TYPE,
	SDCERR_INVALID_WEP_TYPE,
	SDCERR_INVALID_FILE,
	SDCERR_INSUFFICIENT_MEMORY,
	SDCERR_NOT_IMPLEMENTED,
	SDCERR_NO_HARDWARE,
	SDCERR_INVALID_VALUE
};

enum AUTH {
	AUTH_OPEN,
	AUTH_SHARED,
	AUTH_NETWORK_EAP,
};

enum EAPTYPE {
	EAP_NONE,
	EAP_LEAP,
	EAP_EAPFAST,
	EAP_PEAPMSCHAP,
	EAP_PEAPGTC,
	EAP_EAPTLS,
	EAP_EAPTTLS,
	EAP_PEAPTLS,
	EAP_WAPI_CERT
};

enum POWERSAVE {
	POWERSAVE_OFF,
	POWERSAVE_MAX,
	POWERSAVE_FAST,
};

enum WEPTYPE {
	WEP_OFF,
	WEP_ON,
	WEP_AUTO,
	WPA_PSK,
	WPA_TKIP,
	WPA2_PSK,
	WPA2_AES,
	CCKM_TKIP,
	WEP_CKIP,
	WEP_AUTO_CKIP,
	CCKM_AES,
	WPA_PSK_AES,
	WPA_AES,
	WPA2_PSK_TKIP,
	WPA2_TKIP,
	WAPI_PSK,
	WAPI_CERT
};

enum RADIOMODE {
	RADIOMODE_B_ONLY,
	RADIOMODE_BG,
	RADIOMODE_G_ONLY,
	RADIOMODE_BG_LRS,
	RADIOMODE_A_ONLY,
	RADIOMODE_ABG,
	RADIOMODE_BGA,
	RADIOMODE_ADHOC,
	RADIOMODE_GN,
	RADIOMODE_AN,
	RADIOMODE_ABGN,
	RADIOMODE_BGAN,
	RADIOMODE_BGN
};

enum TXPOWER {
	TXPOWER_MAX,
	TXPOWER_1,
	TXPOWER_5,
	TXPOWER_10,
	TXPOWER_20,
	TXPOWER_30,
	TXPOWER_50,
};

enum BITRATE {
	BITRATE_AUTO,
	BITRATE_1,
	BITRATE_2,
	BITRATE_5_5,
	BITRATE_11,
	BITRATE_6,
	BITRATE_9,
	BITRATE_12,
	BITRATE_18,
	BITRATE_24,
	BITRATE_36,
	BITRATE_48,
	BITRATE_54,
	BITRATE_6_5,
	BITRATE_13,
	BITRATE_19_5,
	BITRATE_26,
	BITRATE_39,
	BITRATE_52,
	BITRATE_58_5,
	BITRATE_78,
	BITRATE_104,
	BITRATE_117,
	BITRATE_130,
	BITRATE_7_2,
	BITRATE_14_4,
	BITRATE_21_7,
	BITRATE_28_9,
	BITRATE_43_3,
	BITRATE_57_8,
	BITRATE_65,
	BITRATE_72,
	BITRATE_86_7,
	BITRATE_115_6,
	BITRATE_144_4,
	BITRATE_13_5,
	BITRATE_27,
	BITRATE_40_5,
	BITRATE_81,
	BITRATE_108,
	BITRATE_121_5,
	BITRATE_135,
	BITRATE_162,
	BITRATE_216,
	BITRATE_243,
	BITRATE_270,
	BITRATE_15,
	BITRATE_30,
	BITRATE_45,
	BITRATE_60,
	BITRATE_90,
	BITRATE_120,
	BITRATE_150,
	BITRATE_180,
	BITRATE_240,
	BITRATE_300,
};

enum PREAMBLE {
	PRE_AUTO,
	PRE_SHORT,
	PRE_LONG,
};

enum GSHORTSLOT {
	GSHORT_AUTO,
	GSHORT_OFF,
	GSHORT_ON,
};

enum BT_COEXIST {
	BT_OFF,
	BT_ON,
};

enum REG_DOMAIN {
	REG_FCC,
	REG_ETSI,
	REG_TELEC,
	REG_WW,
	REG_KCC,
	REG_CA,
	REG_FR,
	REG_GB,
	REG_AU,
	REG_NZ,
	REG_CN,
	REG_BR,
	REG_RU,
};

enum PING_PAYLOAD {
	PP_32,
	PP_64,
	PP_128,
	PP_256,
	PP_512,
	PP_1024,
};

enum RX_DIV {
	RXDIV_MAIN,
	RXDIV_AUX,
	RXDIV_START_AUX,
	RXDIV_START_MAIN,
};

enum TX_DIV {
	TXDIV_MAIN,
	TXDIV_AUX,
	TXDIV_ON,
};

enum ROAM_TRIG {
	RTRIG_50,
	RTRIG_55,
	RTRIG_60,
	RTRIG_65,
	RTRIG_70,
	RTRIG_75,
	RTRIG_80,
	RTRIG_85,
	RTRIG_90,
};

enum ROAM_DELTA {
	RDELTA_0,
	RDELTA_5,
	RDELTA_10,
	RDELTA_15,
	RDELTA_20,
	RDELTA_25,
	RDELTA_30,
	RDELTA_35,
	RDELTA_40,
	RDELTA_45,
	RDELTA_50,
	RDELTA_55,
};

enum ROAM_PERIOD {
	RPERIOD_0,
	RPERIOD_5,
	RPERIOD_10,
	RPERIOD_15,
	RPERIOD_20,
	RPERIOD_25,
	RPERIOD_30,
	RPERIOD_35,
	RPERIOD_40,
	RPERIOD_45,
	RPERIOD_50,
	RPERIOD_55,
	RPERIOD_60,
};

enum CCX_FEATURES {
	CCX_OPTIMIZED,
	CCX_FULL,
	CCX_OFF,
};

enum WEPLEN {
	WEPLEN_NOT_SET,
	WEPLEN_40BIT,
	WEPLEN_128BIT,
};

enum FCC_TEST {
	FCCTEST_OFF,
	FCCTEST_TX,
	FCCTEST_RX,
	FCCTEST_FREQ,
};

enum CARDSTATE {
	CARDSTATE_NOT_INSERTED,
	CARDSTATE_NOT_ASSOCIATED,
	CARDSTATE_ASSOCIATED,
	CARDSTATE_AUTHENTICATED,
	CARDSTATE_FCCTEST,
	CARDSTATE_NOT_SDC,
	CARDSTATE_DISABLED,
	CARDSTATE_ERROR,
	CARDSTATE_AP_MODE,
};

#define RADIOTYPE_BCM_OFFSET 0x00
#define RADIOTYPE_AR_OFFSET 0x100
enum RADIOTYPE {
	RADIOTYPE_BG,
	RADIOTYPE_ABG,
	RADIOTYPE_NBG,
	RADIOTYPE_NABG,
	RADIOTYPE_AR_BG,
	RADIOTYPE_AR_ABG,
	RADIOTYPE_AR_NBG,
	RADIOTYPE_AR_NABG,
	RADIOTYPE_NOT_SDC,
	RADIOTYPE_NOT_SDC_1,
};

enum RADIOCHIPSET {
	RADIOCHIPSET_NONE,
	RADIOCHIPSET_SDC10,
	RADIOCHIPSET_SDC15,
	RADIOCHIPSET_SDC30,
	RADIOCHIPSET_SDC40L,
	RADIOCHIPSET_SDC40NBT,
	RADIOCHIPSET_SDC45,
	RADIOCHIPSET_SDC50,
};

enum CERTLOCATION {
	CERT_NONE,
	CERT_FILE,
	CERT_FULL_STORE,
	CERT_IN_STORE
};

enum INTERFERENCE {
	INTER_NONE,
	INTER_NONWLAN,
	INTER_WLAN,
	INTER_AUTO
};

typedef enum TTLS_INNER_METHOD {
	TTLS_AUTO,
	TTLS_MSCHAPV2,
	TTLS_MSCHAP,
	TTLS_PAP,
	TTLS_CHAP,
	TTLS_EAP_MSCHAPV2,
};

typedef enum DFS_CHANNELS {
	DFS_OFF,
	DFS_FULL,
	DFS_OPTIMIZED
};

enum uAPSD {
	UAPSD_AC_VO,
	UAPSD_AC_VI,
	UAPSD_AC_BK,
	UAPSD_AC_BE,
};

#define XMITBIT 0x100

#pragma pack(1)

typedef struct _monitorPacket {
	unsigned long length;
	unsigned long dataOffset;
	struct _monitorPacket *previous;
	unsigned long packetLength;
	unsigned long channel;
	unsigned long speed;
	unsigned long RSSI;
	unsigned long macTime;
	unsigned long CRCflag;
	unsigned long frame;
} monitorPacket;

typedef struct _monitorHeader {
	unsigned long bufSize;
	monitorPacket  *current;
	unsigned long halted;
	unsigned long numPackets;
	unsigned long data;
} monitorHeader;

typedef struct _WEPKEY {
	unsigned long  length;
	unsigned char data[16];
} WEPKey;

#define CRYPT_BUFFER_SIZE 120
typedef struct _CRYPT {
	unsigned long size;
	char  buffer[CRYPT_BUFFER_SIZE];
	unsigned long offset;
} CRYPT;

#define MIN_PSP_DELAY 10
#define MAX_PSP_DELAY 500
#define DEFAULT_PSP_DELAY 200

typedef struct _SDCConfig {
	char        configName[CONFIG_NAME_SZ];
	char        SSID[SSID_SZ];
	char        clientName[CLIENT_NAME_SZ];
	int         txPower;
	AUTH        authType;
	EAPTYPE     eapType;
	POWERSAVE   powerSave;
	WEPTYPE     wepType;
	BITRATE     bitRate;
	RADIOMODE   radioMode;
	CRYPT       userName;
	CRYPT       userPwd;
	CRYPT       PSK;
	CRYPT       WEPKeys;
} SDCConfig;

typedef struct _SDCGlobalConfig {
	unsigned long fragThreshold;
	unsigned long RTSThreshold;
	RX_DIV        RxDiversity;
	TX_DIV        TxDiversity;
	ROAM_TRIG     roamTrigger;
	ROAM_DELTA    roamDelta;
	ROAM_PERIOD   roamPeriod;
	PREAMBLE      preamble;
	GSHORTSLOT    g_shortslot;
	BT_COEXIST    BTcoexist;
	PING_PAYLOAD  pingPayload;
	unsigned long pingTimeout;
	unsigned long pingDelay;
	unsigned long radioState;
	unsigned long displayPasswords;
	unsigned long adminOverride;
	unsigned long txMax;
	FCC_TEST      FCCtest;
	unsigned long testChannel;
	BITRATE       testRate;
	TXPOWER       testPower;
	unsigned long regDomain;
	unsigned long ledUsed;
	unsigned long txTestTimeout;
	unsigned long WMEenabled;
	unsigned long CCXfeatures;
	char          certPath[MAX_CERT_PATH];
	CRYPT         adminPassword;
	unsigned long bLRS;
	unsigned long avgWindow;
	unsigned long probeDelay;
	unsigned long polledIRQ;
	unsigned long keepAlive;
	unsigned long trayIcon;
	unsigned long aggScanTimer;
	unsigned long authTimeout;
	unsigned long autoProfile;
	unsigned long PMKcaching;
	unsigned long defAdhocChannel;
	unsigned long silentRunning;
	unsigned long scanDFSTime;
	unsigned long suppInfo;
#define SUPPINFO_FIPS (1U<<0)
#define SUPPINFO_TLS_TIME_CHECK (1U<<2)
#define SUPPINFO_WPA1_ORIGINAL_OPERATION (1U<< 3)
	unsigned long uAPSD;
	unsigned long txMaxA;
	unsigned long adminFiles;
	unsigned long DFSchannels;
	unsigned long interferenceMode;
	unsigned long authServerType;
	unsigned long TTLSInnerMethod;
	unsigned long aLRS;
	unsigned short roamPeriodms;
	unsigned short BeaconMissTimeout;
	unsigned long Reserved;
} SDCGlobalConfig;

typedef struct _SDC3rdPartyConfig {
	char        clientName[CLIENT_NAME_SZ];
	POWERSAVE   powerSave;
	int         txPower;
	BITRATE     bitRate;
	RADIOMODE   radioMode;
} SDC3rdPartyConfig;

typedef struct _CF10G_STATUS {
	CARDSTATE     cardState;
	char          configName[CONFIG_NAME_SZ];
	unsigned char client_MAC[MAC_ADDR_SZ];
	unsigned char client_IP[IPv4_ADDR_SZ];
	char          clientName[CLIENT_NAME_SZ];
	unsigned char AP_MAC[MAC_ADDR_SZ];
	unsigned char AP_IP[IPv4_ADDR_SZ];
	char          APName[CLIENT_NAME_SZ];
	EAPTYPE       eapType;
	unsigned long channel;
	int           rssi;
	BITRATE       bitRate;
	int           txPower;
	unsigned long driverVersion;
	RADIOTYPE     radioType;
	unsigned long DTIM;
	unsigned long beaconPeriod;
	unsigned long beaconsReceived;
} CF10G_STATUS;

typedef char LRD_WF_ipv6names[INET6_ADDRSTRLEN];
typedef CF10G_STATUS SDC_STATUS, *PSDC_STATUS;

typedef struct _CONFIG_FILE_INFO {
	unsigned long   numConfigs;
	unsigned char   globalConfigPresent;
	unsigned char   thirdPartyConfigPresent;
	unsigned long   sdkVersion;
} CONFIG_FILE_INFO;

typedef struct _SDC_ALL {
	unsigned long		numConfigs;
	SDCConfig			*configs;
	SDC3rdPartyConfig	*configThirdParty;
	SDCGlobalConfig		*configGlobal;
} SDC_ALL;

typedef struct _lrs_channels {
	unsigned long chan[LRS_MAX_CHAN];
} LRD_WF_LRSChannels;

#pragma pack()

typedef struct _pil_info {
	uint32_t api_version;
	char * company_name;
	char * version_string;
	char * serial_number;
	char * product_id;
	void * data;
} LRD_WF_PilInfo;

typedef struct _DHCP_LEASE {
	char interface[20];
	char address[20];
	char subnet_mask[20];
	char routers[100];
	long lease_time;
	int message_type;
	char dns_servers[100];
	char dhcp_server[20];
	char domain_name[200];
	char renew[30];
	char rebind[30];
	char expire[30];
} DHCP_LEASE;

#define LRD_ROUTE_STR_SZ 20
#define LRD_ROUTE_FILE "/proc/net/route"

typedef struct _DEFAULT_ROUTE {
	char interface[LRD_ROUTE_STR_SZ];
	char destination[LRD_ROUTE_STR_SZ];
	char gateway[LRD_ROUTE_STR_SZ];
	int flags;
	unsigned int metric;
	char subnet_mask[LRD_ROUTE_STR_SZ];
	unsigned int mtu;
	unsigned int window;
	unsigned int irtt;
} DEFAULT_ROUTE;

SDCERR GetCurrentConfig(unsigned long *num, char *name);

SDCERR ModifyConfig(char *name, SDCConfig *cfg);

SDCERR GetConfig(char *name, SDCConfig *cfg);

SDCERR DeleteConfig(char *name);

SDCERR SetDefaultConfigValues(SDCConfig *cfg);

SDCERR ClearDefaultConfigValues();

SDCERR CreateConfig(SDCConfig *cfg);

SDCERR GetNumConfigs(unsigned long *num);

SDCERR ActivateConfig(char *name);

SDCERR AddConfig(SDCConfig *cfg);

SDCERR GetAllConfigs(SDCConfig *cfgs, unsigned long *num);

SDCERR SetAllConfigs(unsigned long num, SDCConfig *cfgs);

SDCERR LRD_WF_GetbLRSBitmask(unsigned long numChannels, LRD_WF_LRSChannels channels, unsigned long *bitmask);

SDCERR LRD_WF_GetaLRSBitmask(unsigned long numChannels, LRD_WF_LRSChannels channels, unsigned long *bitmask);

SDCERR LRD_WF_GetbLRSChannels(unsigned long *numChannels, LRD_WF_LRSChannels *channels, unsigned long bitmask);

SDCERR LRD_WF_GetaLRSChannels(unsigned long *numChannels, LRD_WF_LRSChannels *channels, unsigned long bitmask);

SDCERR GetGlobalSettings(SDCGlobalConfig *gcfg);

SDCERR SetGlobalSettings(SDCGlobalConfig *gcfg);

SDCERR Get3rdPartyConfig(SDC3rdPartyConfig *cfg3rd);

SDCERR Set3rdPartyConfig(SDC3rdPartyConfig *cfg3rd);

SDCERR GetCurrentStatus(CF10G_STATUS *status);

SDCERR GetWifiInterfaceName(char *ifname);

SDCERR RadioDisable();

SDCERR RadioEnable();

SDCERR FirstFCCTest(FCC_TEST test, BITRATE rate, int channel,
					TXPOWER testPower, unsigned long timeout);

SDCERR NextFCCTest(FCC_TEST test, BITRATE rate, int channel,
				   TXPOWER testPower, unsigned long timeout);

REG_DOMAIN GetCurrentDomain();

SDCERR updateSROM();

SDCERR testTxData(unsigned char start, char pattern);

SDCERR setMonitorMode(unsigned long enable, unsigned long channel, unsigned long slice, void *buffer, unsigned long bufferSize);

SDCERR GetSDKBuild(unsigned long *build);

SDCERR GetSDKVersion(unsigned long *version);

SDCERR FlushConfigKeys(int configNumber);

SDCERR FlushAllConfigKeys();

SDCERR GetConfigFileInfo(char *filename, CONFIG_FILE_INFO *info);

SDCERR exportSettings(char *filename, SDC_ALL *all);

SDCERR importSettings(char *filename, SDC_ALL *all);

SDCERR SetWEPKey(SDCConfig* cfg, int nWepKey,  WEPLEN keyLength, unsigned char* key, unsigned char txKey);

SDCERR GetWEPKey(SDCConfig* cfg, int nWepKey,  WEPLEN* keyLength, unsigned char* key, unsigned char* txKey);

SDCERR SetMultipleWEPKeys(SDCConfig *cfg,  int nTxKey,  WEPLEN key1Length, unsigned char * key1,
						  WEPLEN key2Length, unsigned char * key2,
						  WEPLEN key3Length, unsigned char * key3,
						  WEPLEN key4Length, unsigned char * key4);

SDCERR GetMultipleWEPKeys(SDCConfig *cfg,  int *nTxKey, WEPLEN *key1Length, unsigned char * key1,
						  WEPLEN *key2Length, unsigned char * key2,
						  WEPLEN *key3Length, unsigned char * key3,
						  WEPLEN *key4Length, unsigned char * key4);

SDCERR SetPSK(SDCConfig * cfg,  char * psk);

SDCERR GetPSK(SDCConfig * cfg,  char * psk);

SDCERR SetLEAPCred(SDCConfig * cfg,  char * username, char * password);

SDCERR GetLEAPCred(SDCConfig * cfg,  char * username, char * password);

SDCERR SetEAPFASTCred(SDCConfig * cfg,  char * username, char * password, char* pacfilename, char* pacpassword);

SDCERR GetEAPFASTCred(SDCConfig * cfg,  char * username, char * password, char* pacfilename, char* pacpassword);

SDCERR SetPEAPGTCCred(SDCConfig* cfg,  char* username, char* password, CERTLOCATION CAcertLocation, char* caCert );

SDCERR GetPEAPGTCCred(SDCConfig* cfg,  char* username, char * password, CERTLOCATION* CAcertLocation, char* caCert );

SDCERR SetPEAPMSCHAPCred(SDCConfig* cfg,  char* username, char* password, CERTLOCATION CAcertLocation, char* caCert );

SDCERR GetPEAPMSCHAPCred(SDCConfig* cfg,  char* username, char * password, CERTLOCATION* CAcertLocation, char* caCert );

SDCERR SetEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION certLocation, char* caCert);

SDCERR GetEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION* certLocation, char* caCert);

SDCERR SetEAPTTLSCred(SDCConfig * cfg,  char * username, char* password, CERTLOCATION certLocation, char* caCert);

SDCERR GetEAPTTLSCred(SDCConfig * cfg,  char * username, char* password, CERTLOCATION* certLocation, char* caCert);

SDCERR SetPEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION certLocation, char* caCert);

SDCERR GetPEAPTLSCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION* certLocation, char* caCert);

typedef struct _scanItemInfo {
       char            ssid[40];
       char            bssid[20];
       int             freq;
       int             channel;
       int             rssi;
       int             security;
       EAPTYPE         eapType;
       WEPTYPE         wepType;
       int             adHocMode;
} SCAN_ITEM_INFO;

typedef struct _SDC_802_11_BSSID_LIST_EX {
	unsigned long  NumberOfItems;
	SCAN_ITEM_INFO Bssid[1];
} SDC_802_11_BSSID_LIST_EX;

SDCERR GetBSSIDList(SDC_802_11_BSSID_LIST_EX *list, int *numBufEntries);

typedef enum _LRD_WF_BSSTYPE {
    INFRASTRUCTURE = 0,
    ADHOC
} LRD_WF_BSSTYPE;

#define LRD_WF_MAX_SSID_LEN    32
#define LRD_WF_MAC_ADDR_LEN    6

typedef struct _LRD_WF_SSID{
	unsigned char len;
	unsigned char val[LRD_WF_MAX_SSID_LEN];
} LRD_WF_SSID;

typedef struct _LRD_WF_SCAN_INFO_ITEM{
	int             channel;
	int             rssi;
	unsigned int    securityMask;
	LRD_WF_BSSTYPE  bssType;
	unsigned int    reserved;
	unsigned char   bssidMac[LRD_WF_MAC_ADDR_LEN];
	LRD_WF_SSID     ssid;
} LRD_WF_SCAN_ITEM_INFO ;

typedef struct _LRD_WF_BSSID_LIST{
	unsigned long  NumberOfItems;
	LRD_WF_SCAN_ITEM_INFO Bssid[1];
} LRD_WF_BSSID_LIST;

SDCERR LRD_WF_GetBSSIDList(LRD_WF_BSSID_LIST *list, int *numBufEntries);

SDCERR LRD_WF_GetSSID(LRD_WF_SSID *ssid);

typedef SDCERR (*SDC_EVENT_HANDLER) (unsigned long event_type, SDC_EVENT *event);

SDCERR SDCRegisterForEvents( unsigned long long eventMask, SDC_EVENT_HANDLER ehandler);

SDCERR SDCRegisteredEventsList( unsigned long long *currentMask);

SDCERR SDCDeregisterEvents();

SDCERR Validate_WEP_EAP_Combo(WEPTYPE wt, EAPTYPE et);

SDCERR SetUserCertPassword(SDCConfig * cfg,  char * userPswd );

SDCERR GetUserCertPassword(SDCConfig * cfg,  char * userPswd );

SDCERR SetWAPICertCred(SDCConfig * cfg,  char * username, char* userCert, CERTLOCATION caCertLocation, char* caCert);

SDCERR LRD_WF_GetRadioChipSet(RADIOCHIPSET *radioChipSet );

SDCERR LRD_WF_GetPilInfo(LRD_WF_PilInfo *pil_info);

SDCERR LRD_WF_GetDHCPLease(DHCP_LEASE *dhcpLease);

SDCERR LRD_WF_GetDHCPIPv4Lease(DHCP_LEASE *dhcpLease, char *interface);

SDCERR LRD_WF_GetDefaultRoute(DEFAULT_ROUTE *default_route, char *file, char *interface);

SDCERR LRD_WF_GetFipsStatus(char * current, char * nextStart);

enum WF_SUPP_LOGLEVEL {
	WF_SUPP_DBG_NONE,
	WF_SUPP_DBG_ERROR,
	WF_SUPP_DBG_WARNING,
	WF_SUPP_DBG_INFO,
	WF_SUPP_DBG_DEBUG,
	WF_SUPP_DBG_MSGDUMP,
	WF_SUPP_DBG_EXCESSIVE
};

SDCERR LRD_WF_SuppLogLevel(WF_SUPP_LOGLEVEL level);

SDCERR LRD_WF_GetSuppLogLevel(WF_SUPP_LOGLEVEL *level);

typedef enum _LRD_WF_DRV_DEBUG {
	LRD_WF_DRV_DEBUG_NONE,
	LRD_WF_DRV_DEBUG_LOW,
	LRD_WF_DRV_DEBUG_MED,
	LRD_WF_DRV_DEBUG_HIGH,
	LRD_WF_DRV_DEBUG_RADIO_SPECIFIC
} LRD_WF_DRV_DEBUG;

SDCERR LRD_WF_Driver_get_debug(LRD_WF_DRV_DEBUG *level, int *dbgmask);

SDCERR LRD_WF_SuppReconfigure(void);

SDCERR LRD_WF_SuppDisconnect(void);

SDCERR LRD_WF_HostAPDRestart();

SDCERR LRD_WF_GetSupportedGlobals(RADIOCHIPSET rcs, SDCGlobalConfig *cfg);

#define securityField_username    (1<<0)
#define securityField_password    (1<<1)
#define securityField_usercert    (1<<2)
#define securityField_usercertpw  (1<<3)
#define securityField_psk         (1<<4)
#define securityField_wepkeys     (1<<5)

SDCERR LRD_WF_ClearCredentialFields(SDCConfig *cfg, uint16_t credBitMask);

SDCERR LRD_WF_ModifyHostAPDConf( const char * key, const char *value );

SDCERR LRD_WF_HostAPDConfGetKeyValue( const char * key, char *value, int len );

SDCERR LRD_WF_GetIpV6Address(LRD_WF_ipv6names ipv6names[], size_t *arr_size);

SDCERR LRD_WF_GetFirmwareVersionString(char *version, int *bufSize);

SDCERR LRD_ENI_SetMethod(char * interfaceName,char * method);

SDCERR LRD_ENI_GetMethod(char * interfaceName,char * method, size_t buff_len);

SDCERR LRD_ENI_AutoStartOn(char *interfaceName);

SDCERR LRD_ENI_AutoStartOff(char *interfaceName);

SDCERR LRD_ENI_GetAutoStart(char * interfaceName, int * autoStart);

SDCERR LRD_ENI_GetInterfacePropertyValue(char *interfaceName, char *prop, char *value, size_t buff_len);

SDCERR LRD_ENI_SetAddress(char *interfaceName, char *address);

SDCERR LRD_ENI_SetNetmask(char *interfaceName, char *address);

SDCERR LRD_ENI_SetGateway(char *interfaceName, char *address);

SDCERR LRD_ENI_SetNameserver(char *interfaceName, char *address);

SDCERR LRD_ENI_SetBroadcastAddress(char * interfaceName, char * address);

SDCERR LRD_ENI_EnableInterface(char *interfaceName);

SDCERR LRD_ENI_DisableInterface(char *interfaceName);

SDCERR LRD_ENI_SetBridgePorts(char *interfaceName, char *ports);

SDCERR LRD_ENI_AddInterface(char *interfaceName);

SDCERR LRD_ENI_RemoveInterface(char *interfaceName);

SDCERR LRD_ENI_GetHostAPD(char * interfaceName, int * hostapd);

SDCERR LRD_ENI_EnableHostAPD(char * interfaceName);

SDCERR LRD_ENI_DisableHostAPD(char * interfaceName);

SDCERR LRD_ENI_ClearProperty(char * interfaceName,char * prop);

SDCERR LRD_ENI_GetNat(char * interfaceName, int * nat);

SDCERR LRD_ENI_DisableNat(char *);

SDCERR LRD_ENI_EnableNat(char *);

SDCERR LRD_ENI_GetInterfacePropertyValue6(char *interfaceName, char *prop, char *value, size_t buff_len);

SDCERR LRD_ENI_GetMethod6(char * interfaceName,char * method, size_t buff_len);

SDCERR LRD_ENI_SetMethod6(char * interfaceName,char * method);

SDCERR LRD_ENI_SetAddress6(char *interfaceName, char *address);

SDCERR LRD_ENI_SetNetmask6(char *interfaceName, char *address);

SDCERR LRD_ENI_SetGateway6(char *interfaceName, char *address);

SDCERR LRD_ENI_SetNameserver6(char *interfaceName, char *address);

SDCERR LRD_ENI_EnableInterface6(char *interfaceName);

SDCERR LRD_ENI_DisableInterface6(char *interfaceName);

SDCERR LRD_ENI_AddInterface6(char *interfaceName);

SDCERR LRD_ENI_RemoveInterface6(char *interfaceName);

SDCERR LRD_ENI_ClearProperty6(char * interfaceName,char * prop);

SDCERR LRD_ENI_GetNat6(char *interfaceName, int *nat);

SDCERR LRD_ENI_DisableNat6(char *);

SDCERR LRD_ENI_EnableNat6(char *);

SDCERR LRD_ENI_SetDhcp6(char *, char *);

SDCERR LRD_WF_SetSuppLogLevel(WF_SUPP_LOGLEVEL level);

SDCERR LRD_WF_Driver_set_debug(LRD_WF_DRV_DEBUG level, int dbgmask);

SDCERR setIgnoreNullSsid(unsigned long value);
