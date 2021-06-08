#pragma once
#include <iostream>
#include <fstream>
#include <vector>
using namespace std;

struct heap {
    vector<int> tree;

    heap() {
          
    }

    void push(int x) {
        tree.push_back(x);
        sift_up(tree.size() - 1);
    }

    int max() {
        if (tree.size() > 1) {
            return tree[1];
        }
        else {
            //Ошибка: попытка найти максимум в пустой куче
        }
    }

    void pop() {
        if (tree.size() > 0) {
            tree[0] = tree.back();
            tree.pop_back();
            sift_down(0);
        }
        else {
            //Ошибка: попытка извлечь максимум из пустой кучи
        }
    }

    //Проталкивание вверх.
    void sift_up(int v) {
        if (v == 0) {
            return;     //Больше некуда подниматься.
        }

        if (tree[v / 2] < tree[v]) {
            swap(tree[v], tree[v / 2]);
            sift_up(v / 2);
        }
    }

    //Проталкивание вниз
    void sift_down(int v) {
        if (v * 2 >= tree.size()) {
            return;     //Больше некуда спускаться.
        }

        //Индекс большего дочернего элемента
        int max_idx;
        if (v * 2 + 1 == tree.size()) {     //Если можно спуститься только влево
            max_idx = v * 2;
        }
        else if (tree[v * 2] >= tree[v * 2 + 1]) {
            max_idx = v * 2;
        }
        else {
            max_idx = v * 2 + 1;
        }

        if (tree[v] < tree[max_idx]) {
            swap(tree[v], tree[max_idx]);
            sift_down(max_idx);
        }
    }

    bool empty() {
        return tree.size() == 1;
    }


    void Read(string name)
    {
        ifstream file(name);
        int temp;

        if (file)
        {
            while (!file.eof())
            {

                file >> temp;
                push(temp);

            }
        }
        else
            cout << "File not found" << endl;

        file.close();

    }

    void outHeap() {
        int i = 0;
        int k = 1;
        while (i < tree.size()) {
            while ((i < k) && (i < tree.size())) {
                cout << tree[i] << " ";
                i++;
            }
            cout << endl;
            k = k * 2 + 1;
        }
    }

    void out() {
        for (int i = 0; i < tree.size(); i++) {
            cout << tree[i] << " ";
        }
        cout << endl;
    }

    int Peek()
    {
        return tree[0];
    }

};




void main()
{
    heap heap;
    int k;
    setlocale(LC_ALL, "rus");
    heap.Read("heap.txt");
    heap.outHeap();
    cout << endl;
    heap.out();
    cout << endl << "Максимальный элемент : " << heap.Peek();
    heap.pop();
    cout << endl << "Новая куча : " << endl;
    heap.outHeap();
    cout << endl;
    heap.out();
    
}