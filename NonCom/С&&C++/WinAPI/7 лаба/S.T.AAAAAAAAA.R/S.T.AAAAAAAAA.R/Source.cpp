// --- ������������ ���������� ����
#include <windows.h>
#include <iostream>
#include <time.h>

using namespace std;
#define PI 3.14156

struct STAR
{
	unsigned N; // ���������� ���������� (��� �����������)
	int x, y; // ���������� ������ ������ (��������������)
	unsigned r; 		// ������ ������ (������)
	COLORREF color; 	// ���� ����� (���� �����������)
};


void random(HWND hwnd,unsigned& N,int& x,int &y,unsigned &r,COLORREF &color)
{
	RECT rect = { 0, 0, 0, 0 };
	GetClientRect(hwnd, &rect);
	srand(time(NULL));
	N = rand() % 25 + 5;
	r = rand() % 220 + 20;
	/*int width=GetSystemMetrics(SM_CXSCREEN);
	int heigth = GetSystemMetrics(SM_CYSCREEN);*/
	int width = rect.right;
	int heigth = rect.bottom;
	x = rand() % (width - r) + r;
	y = rand() % (heigth - r) + r;
	color= RGB(rand() % 255, rand() % 255, rand() % 255);

}

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



// --- �������� ������� �������� ����
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam);

// --- ���������� ����������
HINSTANCE hInst; 		// ���������� ���������� ����������
char ClassName[] = "Window"; 		// �������� ������ ����
char AppTitle[] = "S.T.AAAAAAAAA.R"; 	// ��������� �������� ����

HWND hTextBox;


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


// --- ������� ����
LRESULT CALLBACK WndProc(HWND hWnd, UINT msg, WPARAM wParam, LPARAM lParam)
{

	static STAR str;

	switch (msg)
	{

	
	case WM_PAINT:
	{
		PAINTSTRUCT ps;
		HDC hDC;

		hDC = BeginPaint(hWnd,&ps);
		random(hWnd,str.N, str.x, str.y, str.r, str.color);
		star(hDC, str);
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
