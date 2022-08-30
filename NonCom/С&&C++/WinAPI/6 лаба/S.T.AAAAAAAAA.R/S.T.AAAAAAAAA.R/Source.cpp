// --- ������������ ���������� ����
#include <windows.h>
#include <iostream>
#include <time.h>
#include "resource.h""

using namespace std;
#define PI 3.14156

RECT rect = { 0, 0, 0, 0 };
TCHAR tempText[10];
COLORREF colClndr;

struct STAR
{
	unsigned N=0; // ���������� ���������� (��� �����������)
	int x=0, y=0; // ���������� ������ ������ (��������������)
	unsigned r=0; 		// ������ ������ (������)
	COLORREF color=NULL; 	// ���� ����� (���� �����������)
};

static STAR str;

UINT_PTR CALLBACK CCHookProc
(
	HWND hdlg,
	UINT uiMsg,
	WPARAM wParam,
	LPARAM lParam
);

void ugol(HDC hDC, int x1, int y1, int x2, int y2, int x3, int y3, int n);
// ������� �������
void star(HDC hDC, struct STAR str)
{
	int rc = str.r / 3; // ������ ������ ������
	double a1, a2, a3, d = 2. * PI / (str.N * 2);

	// �������� �������� GDI (������� CreatePen)� �������� ��������� ���� ����� str.color �������� 3 �������

	HPEN hpen;
	
	HGDIOBJ hpenOld;
	hpen = CreatePen(PS_SOLID, 3, str.color);

	// ��������� ��������� ��������� ����������� (������� SelectObject)� ��������� ���������� ���� � �������� hDC � ���������� "�������" ����
	hpenOld = SelectObject(hDC,hpen);

		for (int i = 1; i <= str.N; i++)
			// ������ ��������� �������� ������ ( 1<=i<=N)
		{
			// ����������� �������� �����
			a1 = 2 * PI * (i - 1) / str.N; a2 = a1 + d; a3 = a1 - d;

			// ����� ����, ��������������� ���������
			ugol(hDC, str.x, str.y, str.x + str.r * sin(a1),
				str.y + str.r * cos(a1), str.x + rc * sin(a2), str.y + rc * cos(a2), 25);
			ugol(hDC, str.x, str.y, str.x + str.r * sin(a1), str.y + str.r * cos(a1),
				str.x + rc * sin(a3), str.y + rc * cos(a3), 25);
		}

	// �������������� ��������� ��������� ������������ ��������� "�������" ���� � �������� hDC
		SelectObject(hDC, hpenOld);
		
		// �������� �������� �������� GDI� �������� ���������� ����
		DeleteObject(hpen);
}

// ����� ����, ��������������� ���������
void ugol(HDC hDC, int x1, int y1, int x2, int y2, int x3, int y3, int n)
{
	int n1 = n + 1; double a; int xx1, yy1, xx2, yy2;
	for (int i = 1; i <= n1; i++)
	{
		a = (i - 1.) / n;
		xx1 = x1 + (x2 - x1) * a; yy1 = y1 + (y2 - y1) * a;
		xx2 = x2 + (x3 - x2) * a; yy2 = y2 + (y3 - y2) * a;

		// ����� ��������� ����� �� (xx1,yy1) �� (xx2,yy2)
		// (������� MoveToEx � LineTo)� ����������� ������� ������� ���� � ����� � ������������(xx1, yy1)� �������� ����� �� ������� ������� ���� �� �����(xx2, yy2)
		MoveToEx(hDC, (int)xx1, (int)yy1 - 10, (LPPOINT)NULL);
		LineTo(hDC, (int)xx2, (int)yy2 + 10);
	}
}

void MyMenu(HWND hWnd)
{
	HMENU hMenu = CreateMenu();
	AppendMenu(hMenu, MF_POPUP, 1, "��������������");
	SetMenu(hWnd,hMenu);
}






// --- �������� ������� �������� ����
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam);
INT_PTR CALLBACK SetDLG(HWND hDlg, UINT msg, WPARAM wParam, LPARAM lParam);
// --- ���������� ����������
HINSTANCE hInst; 		// ���������� ���������� ����������
char ClassName[] = "Window"; 		// �������� ������ ����
char AppTitle[] = "S.T.AAAAAAAAA.R.S."; 	// ��������� �������� ����

HWND hTextBox;
static HDC     g_hdc = NULL;
static HBITMAP g_bmp = NULL;

// --- ������� WinMain
int WINAPI WinMain(HINSTANCE hInstance,
	// ���������� ���������� ����������
	HINSTANCE hPrevInstance, // � Win32 ������ ����� NULL
	LPSTR lpCmdLine,
	// ��������� �� ��������� ������. �� // ���������
	// ���������� �������� ������ �� ��������� ������.
	int nCmdShow
	// ����������, ��� ���������� ������������� 
	// ������������ �� �������: ������������
	// (nCmdShow = SW_SHOWMINNOACTIVE) 
	// ��� � ���� ��������� ���� 					//(nCmdShow = SW_SHOWNORMAL).
)
{
	WNDCLASS wc; 	// ��������� ��� ���������� � ������ ����
	HWND hWnd; 	// ���������� �������� ���� ����������
	HBRUSH greyBrush = CreateSolidBrush(RGB(220, 220, 220));
	MSG msg; 	// ��������� ��� �������� ���������
// ��������� ���������� ���������� ���������� � ����������
// ����������, ����� ��� ������������� ��������������� �� �
// ������� ����.
	hInst = hInstance;


	// --- ���������, ���� �� ���������� �������� �����.
	// ������������� �������� FindWindow, ������� ���������
	// ����� ���� �������� 
	// ������ �� ����� ������ ��� �� ��������� ����:
	// HWND FindWindow(LPCTSTR lpClassName,
	// LPCTSTRlpWindowName);
	// ����� �������� lpClassName ���������� ��������� ��
	// ��������� ������, � ������� ���������� �������� ���
	// ������ �������� ����. �� ���� ������ � ���� �� ������ 
	// ����� ������� ��������� ����. ���� ���������� ����� 
	// ���� � �������� ����������, �� ��� ��������� �������
	// �������� ����� �������� lpWindowName. ���� �� �������� 
	// ����� ����, �� �������� lpWindowName ����� �����
	// �������� NULL.
	if ((hWnd = FindWindow(ClassName, NULL)) != NULL)
	{
		// ������������ ����� �� �������, ����� ���������� ���
		// ��������, � ����� ���. ����� �� ��������� ����������, 
		// �� �������, ��� �� ������ �������� ��� ������� ����.
		// �������, ���� ���������� ���� �������� �����,
		// ������������� �������������� � ��������� �� ��������
		// ���� ��� ������� ����. ��� ������ ��, � ���� ������������
		// ������������.
		if (IsIconic(hWnd)) ShowWindow(hWnd, SW_RESTORE);
		SetForegroundWindow(hWnd);

		// ������� ���������� ����� - ������ ����� �����
		// ������������.
		return FALSE;
	}

	// --- ���������� ����� �� ������� - ������� WinMain
	// ���������� � �������������. ���������� ���������
	// WNDCLASS ��� ����������� ������ ����.
	memset(&wc, 0, sizeof(wc));
	wc.lpszClassName = ClassName;		// ��� ������ ����
	wc.lpfnWndProc = (WNDPROC)WndProc;
	// ����� ������� �������
	wc.style = CS_HREDRAW | CS_VREDRAW;	// ����� ������ 
	wc.hInstance = hInstance;		// ��������� ����������
	wc.hIcon = LoadIcon(NULL, IDI_APPLICATION);
	// ����������� ��� ����
	wc.hCursor = LoadCursor(NULL, IDC_ARROW);
	// ������ ���� ��� ����
	wc.hbrBackground = (HBRUSH)GetStockObject(WHITE_BRUSH);
	// ����� ��� ����
	wc.lpszMenuName = NULL;			// ������ ���� ����
	wc.cbClsExtra = 0;			// �������������� ������
	wc.cbWndExtra = 0;			// �������������� ������
	//wc.hbrBackground = greyBrush;
	
	// P���������� ������ ����.
	RegisterClass(&wc);

	// ������� ������� ���� ����������.
	hWnd = CreateWindow(
		ClassName, 			// ��� ������ ����
		AppTitle,			// ��������� ���� 
		WS_OVERLAPPEDWINDOW, 		// ����� ����
		CW_USEDEFAULT,			// X-���������� 
		CW_USEDEFAULT,			// Y-���������� 
		CW_USEDEFAULT,			// ������ ����
		CW_USEDEFAULT,			// ������ ����
		NULL,			// ���������� ����-��������
		NULL,			// ���������� ���� ����
		hInst,		// ���������� ���������� ����������
		NULL);		// �������������� ����������
	if (!hWnd)
	{
		// ���� �� �������, ������ ��������������.
		MessageBox(NULL,
			"Create: error", AppTitle, MB_OK | MB_ICONSTOP);
		return FALSE;
	}

	// ���������� ����.
	ShowWindow(hWnd, nCmdShow);

	// ��������� ���������� ���������� ������� ����.
	UpdateWindow(hWnd);
	
	// ��������� ���� ��������� ������� ���������.
	// ������� GetMessage �������� ��������� �� �������, 
	// ������ false ��� ������� �� ������� ��������� WM_QUIT
	while (GetMessage(&msg, NULL, 0, 0))
	{
		// �������������� ��������� ���������, 
		// ���������� � ������� ����������
		TranslateMessage(&msg);
		// ���������� ��������� ������� ���������
		DispatchMessage(&msg);
	}

	return msg.wParam;
}

BOOL CheckColorProc(COLORREF crColor)
{
	return (crColor == RGB(255, 255, 255) ? FALSE : TRUE);
}

void col(HWND hwnd)
{
	CHOOSECOLOR ch_color = { 0 };
	COLORREF cust_colors[16] = { 0 };
	ch_color.Flags = CC_FULLOPEN | CC_RGBINIT | CC_ENABLEHOOK;
	ch_color.lStructSize = sizeof(CHOOSECOLOR);
	ch_color.lpfnHook = CCHookProc;
	ch_color.hwndOwner = hwnd;
	ch_color.lCustData = (LRESULT)CheckColorProc;
	ch_color.lpCustColors = cust_colors;
	if (ChooseColor(&ch_color))
	{
		colClndr = ch_color.rgbResult;
	}
}

INT_PTR CALLBACK SetDLG(HWND hDlg, UINT msg, WPARAM wParam, LPARAM lParam)
{

	switch (msg)
	{
	case WM_INITDIALOG:
		_itoa_s(str.N, tempText,10);
		SetDlgItemText(hDlg, IDC_N, tempText);
		_itoa_s(str.x, tempText, 10);
		SetDlgItemText(hDlg, IDC_X, tempText);
		_itoa_s(str.y, tempText, 10);
		SetDlgItemText(hDlg, IDC_Y, tempText);
		_itoa_s(str.r, tempText, 10);
		SetDlgItemText(hDlg, IDC_R, tempText);
		_itoa_s(str.color, tempText, 10);
		SetDlgItemText(hDlg, IDC_chCOLOR, tempText);
		return TRUE;

	case WM_COMMAND:
		switch(LOWORD(wParam))
		{
		case IDOK:
			GetDlgItemText(hDlg, IDC_N, tempText,10);
			str.N=atoi(tempText);
			GetDlgItemText(hDlg, IDC_X, tempText, 10);
			str.x = atoi(tempText);
			GetDlgItemText(hDlg, IDC_Y,tempText, 10);
			str.y = atoi(tempText);
			GetDlgItemText(hDlg, IDC_R, tempText, 10);
			str.r = atoi(tempText);
			
			str.color = colClndr;
			EndDialog(hDlg, IDOK);
			return TRUE;

		case IDCANCEL: EndDialog(hDlg, IDCANCEL);
			return TRUE;
		case IDC_COLOR:
			col(hDlg);
			_itoa_s(colClndr, tempText, 10);
			SetDlgItemText(hDlg, IDC_chCOLOR, tempText);
			return TRUE;
			
			
		}
	}
	return FALSE;
}

bool flag = false;
// --- ������� ����
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam)
{

	switch (msg)
	{

	case WM_COMMAND:
	{
		switch (LOWORD(wParam))
		{
			case 1: int iCode = DialogBox(hInst, MAKEINTRESOURCE(IDD_SETTINGS), hWnd, SetDLG);
				if (iCode == IDOK)
				{
					flag = true;
					InvalidateRect(hWnd, 0, TRUE);
					UpdateWindow(hWnd);
					flag = false;
				}
					
		}
	};
		break;
	case WM_RBUTTONDOWN:
		
		
		break;
	
	case WM_PAINT:
	{
		HDC hDC;
		PAINTSTRUCT ps;
		MyMenu(hWnd);
		hDC = BeginPaint(hWnd, &ps);
		
		if (flag)
		{

			//random(hWnd, str.N, str.x, str.y, str.r, str.color);
			star(hDC, str);

			flag = false;
			Sleep(1000 / 60);
		}
		EndPaint(hWnd, &ps);
		
	}; break;


	
	case WM_DESTROY:
	{
		
		PostQuitMessage(0);
	}; break;

	
	default: return DefWindowProc(hWnd, msg, wParam, lParam);
	}
	return 0l;
}


typedef BOOL CHECKCOLORPROC(COLORREF);
UINT_PTR CALLBACK CCHookProc
(
	HWND hdlg,
	UINT uiMsg,
	WPARAM wParam,
	LPARAM lParam
)
{
	static UINT uWM_ChooseColorOK = 0U;
	static CHECKCOLORPROC* lpfnCheckColor = NULL;

	switch (uiMsg)
	{
	case WM_INITDIALOG:
		uWM_ChooseColorOK = RegisterWindowMessage(COLOROKSTRING);
		lpfnCheckColor = (CHECKCOLORPROC*)(((LPCHOOSECOLOR)lParam)->lCustData);
		break;
	default:
		if (uWM_ChooseColorOK && uiMsg == uWM_ChooseColorOK)
		{
			COLORREF crResColor = ((LPCHOOSECOLOR)lParam)->rgbResult;
			if (lpfnCheckColor && !lpfnCheckColor(crResColor))
			{
				MessageBox(hdlg, ("��������� ���� ������������!"), ("������ ������ �����"), MB_OK | MB_ICONERROR);
				return TRUE;
			}
		}
	}
	return FALSE;
}